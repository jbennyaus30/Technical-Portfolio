#include "contiki.h"
#include "lib/random.h"
#include "sys/ctimer.h"
#include "net/uip.h"
#include "net/uip-ds6.h"
#include "net/uip-udp-packet.h"
#include "dev/button-sensor.h"
#include "dev/leds.h"  // Include the LEDs library
#include <stdio.h>
#include <string.h>

#define UDP_CLIENT_PORT 8765
#define UDP_SERVER_PORT 5678
#define MAX_PAYLOAD_LEN 30

static struct uip_udp_conn *client_conn;
static uip_ipaddr_t server_ipaddr;
static int light_status = 0;  // 0 = OFF, 1 = ON

PROCESS(smartlight_process, "HOME: Smart Light");
AUTOSTART_PROCESSES(&smartlight_process);

/*---------------------------------------------------------------------------*/
static void
tcpip_handler(void)
{
  char *str;

  if(uip_newdata()) {
    str = uip_appdata;
    str[uip_datalen()] = '\0';
    printf("DATA recv '%s'\n", str);
    if(strcmp(str, "ON") == 0) {
      light_status = 1;
      leds_on(LEDS_ALL);  // Turn on red LED when light is ON
      printf("Light turned ON from server\n");
    } else if(strcmp(str, "OFF") == 0) {
      light_status = 0;
      leds_off(LEDS_ALL);  // Turn off red LED when light is OFF
      printf("Light turned OFF from server\n");
    }
  }
}
/*---------------------------------------------------------------------------*/
static void
send_packet(void *ptr)
{
  char buf[MAX_PAYLOAD_LEN];
  sprintf(buf, "Light is %s", light_status ? "ON" : "OFF");
  uip_udp_packet_sendto(client_conn, buf, strlen(buf),
                        &server_ipaddr, UIP_HTONS(UDP_SERVER_PORT));
  printf("DATA sent to server: %s\n", buf);
}
/*---------------------------------------------------------------------------*/
static void
set_global_address(void)
{
  uip_ip6addr(&server_ipaddr, 0xaaaa, 0, 0, 0, 0, 0x00ff, 0xfe00, 1);
  uip_ds6_addr_add(&server_ipaddr, 0, ADDR_AUTOCONF);
}
/*---------------------------------------------------------------------------*/
PROCESS_THREAD(smartlight_process, ev, data)
{
  PROCESS_BEGIN();

  SENSORS_ACTIVATE(button_sensor);
  leds_off(LEDS_ALL);  // Ensure the red LED starts off
  set_global_address();
  printf("UDP client process started\n");

  /* New UDP connection */
  client_conn = udp_new(NULL, UIP_HTONS(UDP_SERVER_PORT), NULL);
  udp_bind(client_conn, UIP_HTONS(UDP_CLIENT_PORT));
  
  printf("Created a connection with the server. Local port: %u, Remote port: %u\n",
         UIP_HTONS(client_conn->lport), UIP_HTONS(client_conn->rport));

  while(1) {
    PROCESS_YIELD();
    
    if(ev == tcpip_event) {
      tcpip_handler();
    }

    if(ev == sensors_event && data == &button_sensor) {
      light_status = !light_status;
      printf("HOME: Smart Light %s\n", light_status ? "ON" : "OFF");

      if(light_status) {
        leds_on(LEDS_ALL);  // Turn on red LED if the light is ON
      } else {
        leds_off(LEDS_ALL);  // Turn off red LED if the light is OFF
      }

      send_packet(NULL);
    }
  }

  PROCESS_END();
}
