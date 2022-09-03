function VoirModif() {
    var e = document.getElementById("info");
    if(e.classList.contains("display")){
        e.classList.remove("display");
    }else{
        e.classList.add("display");
    }
}
