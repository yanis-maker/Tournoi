$(function(){
    var nbTeams = $("#match_gen ul").length+1
    var round = 1
    while(nbTeams>1){
        nbTeams /= 2
        for(var i=0; i<nbTeams; i++){
            var match = $("#match_gen ul").first()
            var ndiv = document.createElement('div')
            $(`#bracket_round_${round}`).append($(ndiv))
            $(ndiv).append(match).css('height', `${100/nbTeams}%`).addClass('center-div')
        }
        $(`#bracket_round_${round}`).css('height', $(`#bracket_round_1`).css('height'))
        round++
    }
})