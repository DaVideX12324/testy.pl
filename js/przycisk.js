
function init() {
var a = document.getElementById("min_oc");
    var btn = document.getElementById("asdf");
    btn.addEventListener("click", onclick, false);
				a.innerHTML= '<br><br><div id="pkt">Wartość:<br><input class="text" type="number" name="ile" id="has" value="50">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div id="pkt">Jednostka:<br><select id="kat" name="czego"><option value="1">%</option><option value="2">pkt</option></SELECT></div><br><br><br><br><br><br>';
				if(document.querySelector('[id="btn"]').checked == false)
				{
					document.querySelector('[id="btn"]').checked = true;
				}
				else
				{
					document.querySelector('[id="btn"]').checked = false;
				}
            
        
}
/*

var a = document.getElementById("min_oc");
function clickUpdates() {
    
				var count = 1;
    var next = function() {
        switch(count) {
            case 0:
          
				a.innerHTML= '<br><br><div id="pkt">Wartość:<br><input class="text" type="number" name="ile" id="has" value="50">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div id="pkt">Jednostka:<br><select id="kat" name="czego"><option value="1">%</option><option value="2">pkt</option></SELECT></div><br><br><br>';
				if(document.querySelector('[id="btn"]').checked == false)
				{
					document.querySelector('[id="btn"]').checked = true;
				}
				else
				{
					document.querySelector('[id="btn"]').checked = false;
				}
					count = 1;
            break;
			
            default:
			
			a.innerHTML= "";
				if(document.querySelector('[id="btn"]').checked == true)
			{
				document.querySelector('[id="btn"]').checked = false;
			}
			else
			{
				document.querySelector('[id="btn"]').checked = true;
			}
					count = 0;
		
            break;
            
            
        }
    }
    
    return next;
}


function init2() {
    var onclick2 = clickUpdates2();
    var btn2 = document.getElementById("asdf2");
    btn2.addEventListener("click", onclick2, false);
}

var a2 = document.getElementById("prog_oc");
function clickUpdates2() {
    var count2 = 0;
    var next2 = function() {
        switch(count2) {
            case 0:
          
				a2.innerHTML= '<br><br><div id="pkt">Rodzaje ocen:<br><select id="kat" name="czego"><option value="1">Oceny</option><option value="2">Oceny i oceny opisowe</option><option value="3">Oceny opisowe</option></SELECT>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div id="pkt">Jednostka przedziałów:<br><select id="kat" name="czego"><option value="1">%</option><option value="2">pkt</option></SELECT></div><br><br><br><br><input type="button" class="btn2" id="asdf3" value="+ Dodaj przedział"><br><br><br>';
				if(document.querySelector('[id="btn2"]').checked == false)
				{
					document.querySelector('[id="btn2"]').checked = true;
				}
				else
				{
					document.querySelector('[id="btn2"]').checked = false;
				}
					count2 = 1;
            break;
			
            default:
			
			a2.innerHTML= "";
				if(document.querySelector('[id="btn2"]').checked == true)
			{
				document.querySelector('[id="btn2"]').checked = false;
			}
			else
			{
				document.querySelector('[id="btn2"]').checked = true;
			}
					count2 = 0;
		
            break;
            
            
        }
    }
    
    return next2;
}

	let i=1;

function clickUpdates3() {

	
    var count = "0";
    var next3 = function() 
	{	

			i++;						
			
			   			
			const node = document.createElement("span");
			
			node.setAttribute("id","100000"+i);
			
			node.innerHTML="<a onclick='usun(this.id)' id='100000"+i+"' class='odp_usun'>Usuń odpowiedź</a><textarea class='okk' id='o1000"+i+"'></textarea><span id=tu2_o1000"+i+"></span>";
					
			document.getElementById("progi_ocen").appendChild(node);

	
    }
			count = 0;
			
    return next3;
}
*/


function addLoadEvent(func) { 
	var oldonload = window.onload; 
	if (typeof window.onload != 'function') { 
		window.onload = func; 
	} else { 
		window.onload = function() { 
			if (oldonload) { 
				oldonload(); 
			} 
			func(); 
		} 
	} 
} 

addLoadEvent(init); /*
addLoadEvent(init2); */