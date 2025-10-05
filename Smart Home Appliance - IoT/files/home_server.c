#include "contiki.h"
#include "contiki-lib.h"
#include "contiki-net.h"
#include "net/uip.h"
#include "net/rpl/rpl.h"
#include "dev/button-sensor.h"
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#define UDP_CLIENT_PORT 8765
#define UDP_SERVER_PORT 5678
#define MAX_PAYLOAD_LEN 30

static struct uip_udp_conn *server_conn;
static int light_status = 0;
static int fan_status = 0;
static int ac_status = 0;

/*---------------------------------------------------------------------------*/
PROCESS(udp_server_process, "UDP server process");
AUTOSTART_PROCESSES(&udp_server_process);
/*---------------------------------------------------------------------------*/

static void
tcpip_handler(void)
{
  char *appdata;

  if(uip_newdata()) {
    appdata = (char *)uip_appdata;
    appdata[uip_datalen()] = '\0';
    printf("DATA recv '%s'\n", appdata);

    /* Check which device is being toggled based on message */
    if(strcmp(appdata, "Light is ON") == 0) {
      light_status = 1; // Assuming this is for the light node for now
      printf("HOME: Smart Light Turning ON\n");
    } else if(strcmp(appdata, "Light is OFF") == 0) {
      light_status = 0;
      printf("HOME: Smart Light Turning OFF\n");
    } else if (strcmp(appdata, "Fan is ON") == 0) {
      fan_status = 1;
      printf("HOME: Smart Fan Turning ON\n");
    } else if (strcmp(appdata, "Fan is OFF") == 0) {
      fan_status = 0;
      printf("HOME: Smart Fan Turning OFF\n");
    } else if (strcmp(appdata, "AC is ON") == 0) {
      ac_status = 1;
      printf("HOME: Smart AC Turning ON\n");
    } else if (strcmp(appdata, "AC is OFF") == 0) {
      ac_status = 0;
      printf("HOME: Smart AC Turning OFF\n");
    } else if (strcmp(appdata, "Washing Machine is ON") == 0) {
      ac_status = 1;
      printf("HOME: Smart Washing Machine Turning ON\n");
    } else if (strcmp(appdata, "Washing Machine is OFF") == 0) {
      ac_status = 0;
      printf("HOME: Smart Washing Machine Turning OFF\n");
    } else {
      printf("Unknown message received\n");
    }
  }
}

/*---------------------------------------------------------------------------*/
static void
set_global_address(void)
{
  uip_ipaddr_t ipaddr;
  struct uip_ds6_addr *root_if;

  /* Set the server's IPv6 address */
  uip_ip6addr(&ipaddr, 0xaaaa, 0, 0, 0, 0, 0x00ff, 0xfe00, 1);
  uip_ds6_addr_add(&ipaddr, 0, ADDR_MANUAL);
  
  root_if = uip_ds6_addr_lookup(&ipaddr);
  if(root_if != NULL) {
    rpl_dag_t *dag;
    dag = rpl_set_root(RPL_DEFAULT_INSTANCE, &ipaddr);
    uip_ip6addr(&ipaddr, 0xaaaa, 0, 0, 0, 0, 0, 0, 0);
    rpl_set_prefix(dag, &ipaddr, 64);
    printf("Created a new RPL DAG\n");
  }
}

/*---------------------------------------------------------------------------*/
PROCESS_THREAD(udp_server_process, ev, data)
{
  PROCESS_BEGIN();

  SENSORS_ACTIVATE(button_sensor);
  set_global_address();

  printf("UDP server started\n");

  /* New UDP connection */
  server_conn = udp_new(NULL, UIP_HTONS(UDP_CLIENT_PORT), NULL);
  udp_bind(server_conn, UIP_HTONS(UDP_SERVER_PORT));

  printf("Created a server connection. Local port: %u\n", UIP_HTONS(server_conn->lport));

  while(1) {
    PROCESS_YIELD();
    
    if(ev == tcpip_event) {
      tcpip_handler();
    } else if(ev == sensors_event && data == &button_sensor) {
      printf("Global repair initiated\n");
      rpl_repair_root(RPL_DEFAULT_INSTANCE);
    }
  }

  PROCESS_END();
}
/*---------------------------------------------------------------------------*/
