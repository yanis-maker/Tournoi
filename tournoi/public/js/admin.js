
function Show(a) {
  if(a==4){
    var x = document.getElementById("GestAll");
    document.getElementById("gestDispo").style.display = "none";
  }

  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function Show2(a) {
  var x=document.getElementById(a);
  if (x.style.display === "none") {
    x.style.textalign = "center";
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

}
