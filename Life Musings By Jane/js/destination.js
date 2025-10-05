const allAlbumItem = document.querySelectorAll('album-item');
        const imgModalDiv = document.getElementById('img-modal-box');
        const modalCloseBtn = document.getElementById('modal-close-btn');
        const nextBtn = document.getElementById('next-btn');
        const prevBtn = document.getElementById('prev-btn');

        let imgIndex = 0;

        allAlbumItem.forEach((albumItem) => {
            albumItem.addEventListener('click', () => {
                imgModalDiv.style.display = "block";
                let imgSrc=albumItem.querySelector('img').src;
                console.log(imgSrc);
                imgIndex = parseInt(imgSrc.split("-")[1].substring(0, 1));
                showImageContent(imgIndex);
            })
        });

        function showImageContent(index){
            imgModalDiv.querySelector('#img-modal img').src = 'images/places-${index}.jpg'
        }
        modalCLoseBtn.addEventListener('click', () => {
            imgModalDiv.style.display = "none";
        })