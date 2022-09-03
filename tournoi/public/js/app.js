function show_off() {
    const pass_field = document.querySelector('.password');
    const show_btn = document.querySelector('.show-btn');
    show_btn.addEventListener('click', function(){
        if(pass_field.type === "password"){
            pass_field.type = "text";
            show_btn.style.color = "#000";
            show_btn.textContent ="HIDE";
        }else{
            pass_field.type = "password";
            show_btn.style.color = "#000";
            show_btn.textContent ="SHOW";
        }
    });
}
