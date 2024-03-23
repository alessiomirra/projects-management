function checkScreenWidth() {
    if (window.innerWidth < 768) {
        document.getElementById('vertical-menu').style.display = 'none';
    } else {
        document.getElementById('vertical-menu').style.display = 'block';
    }
}

function previewFile(){
    let preview = document.querySelector("#avatar-preview");
    let file = document.querySelector("#avatar").files[0];
    let reader = new FileReader(); 

    reader.addEventListener("load", function(){
        preview.src = reader.result; 
    }, false);

    if (file){
        reader.readAsDataURL(file);
    };
}

checkScreenWidth();

window.addEventListener('resize', checkScreenWidth);