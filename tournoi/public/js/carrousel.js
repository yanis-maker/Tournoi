var displays = $('#carrousel a')
var onDisplay = 0
var timer = 10

function updateCarrousel() {
    $('#carrousel').css('background-image', `url("../img/display_${onDisplay}.jpg")`)
    displays.hide()
    $(`#info_${onDisplay}`).show()
}

$(function(){

    $('#prevBtn').click(function() {
        timer = 10
        onDisplay = Math.max(0, onDisplay-1)
        updateCarrousel()
    })

    $('#nextBtn').click(function() {
        timer = 10
        onDisplay = Math.min(onDisplay+1, displays.length-1)
        updateCarrousel()
    })
})

$(async function(){
    while (true) {
        while (timer>0) {
            await sleep(1000)
            timer -= 1
        }
        timer = 10
        onDisplay = (onDisplay+1)%3
        updateCarrousel()
    }
})

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms))
}