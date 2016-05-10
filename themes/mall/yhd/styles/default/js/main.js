// JavaScript Document 
 function searchtype(type){
   if (type=='goods'){
      document.getElementById('s_goods').className = 'active';
	  document.getElementById('s_store').className = '';
	  document.getElementById('search-act').value = 'index';
   }
   else{
	  document.getElementById('s_goods').className = '';
	  document.getElementById('s_store').className = 'active';
	  document.getElementById('search-act').value = 'store';
   }
}

 function stab(cur,name){
	for (var i=1;i<=4;i++){
		document.getElementById(name+'-'+i).className='';
	}
	document.getElementById(name+'-'+cur).className='stab-hover-'+cur;
	
	for (i=1;i<=4;i++){
	   document.getElementById(name+'-content-'+i).style.display="none";
	}
	document.getElementById(name+'-content-'+cur).style.display="block";
 }


