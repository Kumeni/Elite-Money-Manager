const closePopups = () => {
    const popups = document.getElementsByClassName("popup");
    let i=0;

    for(i=0; i<popups.length; i++){
        popups[i].style.display = "none";
    }
}