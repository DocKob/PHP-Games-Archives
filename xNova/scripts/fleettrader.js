// This checks its a number.
function es_numero(input){
return !isNaN(input)&&parseInt(input)==input;
}
// This checks its lower or equal to max.
function comprobar(campo,val_num){
     
var elvalor = document.getElementById(campo).value;  
if(es_numero(elvalor)){
     
if(elvalor > val_num){
document.getElementById(campo).value= val_num;
}
     
} else{
alert("Por favor, ingresa un numero en el campo.");
}
     
}

function updateVars()
{       
        var ID  = $('#id').val();
        $('#img').attr('src', $('#img').attr('dir')+ID+'.png');
		$('#count').attr('onKeyup', 'comprobar(this.id,'+CostInfo[$('#id').val()][0]+');Total();');
        $('#metal').text(NumberGetHumanReadable(CostInfo[ID][1] * (1 - Charge / 100)));
        $('#crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * (1 - Charge / 100)));
        $('#deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * (1 - Charge / 100)));
		$('#norio').text(NumberGetHumanReadable(CostInfo[ID][5] * (1 - Charge / 100)));	
        $('#darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * (1 - Charge / 100)));
        Reset();
}

function updateText(n) {
    var sel= document.getElementById('cost');
    var inputSum= document.getElementById('sum');
    var selValue = sel.options[sel.selectedIndex].value;
    inputSum.value= +selValue + n;
}

function MaxShips()
{
        $('#count').val(CostInfo[$('#id').val()][0]);
        Total();
}

function Total()
{
        var Count       = $('#count').val();

        var ID  = $('#id').val();
        console.l
        $('#total_metal').text(NumberGetHumanReadable(CostInfo[ID][1] * Count * (1 - Charge / 100)));
        $('#total_crystal').text(NumberGetHumanReadable(CostInfo[ID][2] * Count * (1 - Charge / 100)));
        $('#total_deuterium').text(NumberGetHumanReadable(CostInfo[ID][3] * Count * (1 - Charge / 100)));
		$('#total_norio').text(NumberGetHumanReadable(CostInfo[ID][5] * Count * (1 - Charge / 100)));
        $('#total_darkmatter').text(NumberGetHumanReadable(CostInfo[ID][4] * Count * (1 - Charge / 100)));
}

function Reset()
{
        $('#count').val(0);
        $('#total_metal').text(0);
        $('#total_crystal').text(0);
        $('#total_deuterium').text(0);
		$('#total_norio').text(0);
        $('#total_darkmatter').text(0);
}

$('#charge').text(Charge + "%")