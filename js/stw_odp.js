function typ() {
    var d = document.getElementById("rej_typ").value;

    // Pobierz istniejące pola odpowiedzi
    const odp = document.querySelectorAll('[name="popr_odp[]"]');

    if (d === "1") { // Jednokrotny wybór
        odp.forEach(element => {
            element.setAttribute("type", "radio");
            element.checked = false; // Odznacz wszystkie odpowiedzi
        });
        document.getElementById('dodaj_odp').removeAttribute("hidden");
        document.getElementById('dod').removeAttribute("hidden");
    } else if (d === "2") { // Wielokrotny wybór
        odp.forEach(element => {
            element.setAttribute("type", "checkbox");
            element.checked = false; // Odznacz wszystkie odpowiedzi
        });
        document.getElementById('dodaj_odp').removeAttribute("hidden");
        document.getElementById('dod').removeAttribute("hidden");
    } else if (d === "3") { // Opisowe
        odp.forEach(element => {
            element.checked = false; // Odznacz wszystkie odpowiedzi
            element.parentNode.style.display = "none"; // Ukryj odpowiedzi
        });
        document.getElementById('dodaj_odp').setAttribute("hidden", "true");
        document.getElementById('dod').setAttribute("hidden", "true");
    }
}

onload = init;
	let i=1;
function init() {
	let abc = "Radio";
	
    let onclick = clickUpdates();
    let btn = document.getElementById("dod");
    btn.addEventListener("click", onclick, false);
		
			   			
	const node = document.createElement("span");
			
	node.setAttribute("id",i);
			
	node.innerHTML="<a class='odp_a' id="+i+" onclick='pop_odp(this.id) '><input checked type='"+abc+"' value='"+i+"' class='odp_typ' id='popr_odp"+i+"' name='popr_odp[]'>Poprawna odpowiedź</a> <a onclick='usun(this.id)' id='"+i+"' class='odp_usun'>Usuń odpowiedź</a><textarea class='okk'  id='o"+i+"'></textarea><span id=tu2_o"+i+"></span>";
					
			document.getElementById("dodaj_odp").appendChild(node);

	

	tinymce.init
	({
		selector: '#o'+i,
		width: 900,
		height: 150,
		plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
		toolbar: 'undo redo | blocks  fontsize | bold italic underline | link image media table  | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
		menubar:false, 
		file_picker_types: 'image',
		/* and here's our custom image picker*/
		file_picker_callback: (cb, value, meta) =>
		{
			const input = document.createElement('input');
			input.setAttribute('type', 'file');
			input.setAttribute('accept', 'image/*');

			input.addEventListener('change', (e) =>
			{
				const file = e.target.files[0];

				const reader = new FileReader();
				reader.addEventListener('load', () =>
				{
					/*
					Note: Now we need to register the blob in TinyMCEs image blob
					registry. In the next release this part hopefully won't be
					necessary, as we are looking to handle it internally.
					*/
					const id = 'blobid' + (new Date()).getTime();
					const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
					const base64 = reader.result.split(',')[1];
					const blobInfo = blobCache.create(id, file, base64);
					blobCache.add(blobInfo);

					/* call the callback and populate the Title field with the file name */
					cb(blobInfo.blobUri(), { title: file.name });
				});
				reader.readAsDataURL(file);
			});

			input.click();
		},
	});

	
}
	var a = document.getElementById("dodaj_odp");

	
function clickUpdates() {

	let abc = "Radio";
	
    var count = "0";
    var next = function() 
	{	
	
	var d = document.getElementById("rej_typ").value;
	
	if(d==1)
	{
		const odp=document.querySelectorAll('[name$="popr_odp[]"]');
		odp.forEach(element => 
		{	
			abc= "Radio"
			element.setAttribute("type", abc);
		});
		document.getElementById('dodaj_odp').removeAttribute("hidden");
		document.getElementById('dod').removeAttribute("hidden");
	}	
	
	if(d==2)
	{
		const odp=document.querySelectorAll('[name$="popr_odp[]"]');
		odp.forEach(element => 
		{
			abc= "Checkbox"
			element.setAttribute("type", abc);
		});
		document.getElementById('dodaj_odp').removeAttribute("hidden");
		document.getElementById('dod').removeAttribute("hidden");
	}	
	
	if(d==3)
	{
		document.getElementById('dodaj_odp').setAttribute("hidden", true);
		document.getElementById('dod').setAttribute("hidden", true);
	}		
	
			i++;						
			
			   			
			const node = document.createElement("span");
			
			node.setAttribute("id",i);
			
			node.innerHTML="<a class='odp_a' id="+i+" onclick='pop_odp(this.id) '><input type='"+abc+"' value='"+i+"' class='odp_typ' id='popr_odp"+i+"' name='popr_odp[]'>Poprawna odpowiedź</a> <a onclick='usun(this.id)' id='"+i+"' class='odp_usun'>Usuń odpowiedź</a><textarea class='okk' id='o"+i+"'></textarea><span id=tu2_o"+i+"></span>";
					
			document.getElementById("dodaj_odp").appendChild(node);

	

	tinymce.init({
		selector: '#o'+i,
		width: 900,
		height: 150,
		plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
		toolbar: 'undo redo | blocks  fontsize | bold italic underline | link image media table  | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
		menubar:false, 
		file_picker_types: 'image',
		/* and here's our custom image picker*/
		file_picker_callback: (cb, value, meta) =>
		{
			const input = document.createElement('input');
			input.setAttribute('type', 'file');
			input.setAttribute('accept', 'image/*');

			input.addEventListener('change', (e) =>
			{
				const file = e.target.files[0];

				const reader = new FileReader();
				reader.addEventListener('load', () =>
				{
					/*
					Note: Now we need to register the blob in TinyMCEs image blob
					registry. In the next release this part hopefully won't be
					necessary, as we are looking to handle it internally.
					*/
					const id = 'blobid' + (new Date()).getTime();
					const blobCache =  tinymce.activeEditor.editorUpload.blobCache;
					const base64 = reader.result.split(',')[1];
					const blobInfo = blobCache.create(id, file, base64);
					blobCache.add(blobInfo);

					/* call the callback and populate the Title field with the file name */
					cb(blobInfo.blobUri(), { title: file.name });
				});
				reader.readAsDataURL(file);
			});

			input.click();
		},
	});
    }
			count = 0;
			
    return next;
}


function Zapis() 
{
	var tresc = tinymce.get("p_tres").getContent();
	document.getElementById("tu").innerHTML="<input type='text'  value='"+tresc+"' Hidden name='p_tresc'/>";
		
	let h=1;
	const odp=document.querySelectorAll('textarea.okk');
	odp.forEach(element => 
	{	
		var asdf=element.id;
		var tresc2 = tinymce.get(asdf).getContent();
		document.getElementById("tu2_"+asdf).innerHTML="<input type='text'  value='"+tresc2+"' Hidden name='jest_"+h+"'/><input type='text'  Hidden value='"+tresc2+"' name='jest_'/>";	
		h++;	
		
		if((tresc==0)||(tresc2==0))
		{
			event.preventDefault();
			shouldChangePage = alert("Wypełnij wszystkie pola");
			odp=0;
		}
	});
	
				
}

	
var czy = 0;
 
function pop_odp(a)
{
   	switch(czy)
	{
		default:
			if(document.querySelector('[id$="popr_odp'+a+'"]').checked == false)
			{
				document.querySelector('[id$="popr_odp'+a+'"]').checked = true;
				czy = 1;
			}
			else
			{
				document.querySelector('[id$="popr_odp'+a+'"]').checked = false;
				czy = 0;
			}
			break;
		
	   case 1:
			if(document.querySelector('[id$="popr_odp'+a+'"]').checked == true)
			{
				document.querySelector('[id$="popr_odp'+a+'"]').checked = false;
				czy = 0;
			}
			else
			{
				document.querySelector('[id$="popr_odp'+a+'"]').checked = true;
				czy = 1;
			}
			break;
	}
}


function usun(id_odp)
{	
	document.getElementById(id_odp).outerHTML = "";
}