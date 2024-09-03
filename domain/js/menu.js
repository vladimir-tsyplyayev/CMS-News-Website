var activeMenuItem = new Array();
	function isUlInArray(inputObj,ulObj){
		while(inputObj && inputObj.id!='listMenu'){
			if(inputObj==ulObj)return true;
			inputObj = inputObj.parentNode;			
		}		
		return false;
	}
	function showHideSub(e,inputObj){
		if(!inputObj)inputObj=this;
		var parentObj = inputObj.parentNode;
		var ul = parentObj.getElementsByTagName('UL')[0];
		if(activeMenuItem.length>0){
			for(var no=0;no<activeMenuItem.length;no++){
				if(!isUlInArray(ul,activeMenuItem[0]) && !isUlInArray(activeMenuItem[0],ul)){
					activeMenuItem[no].style.display='none';
					activeMenuItem.splice(no,1);
					no--;
				}
			}			
		}
		if(ul.offsetHeight == 0){
			ul.style.display='block';
			activeMenuItem.push(ul);
		}else{
			ul.style.display='none';
		}
	}
	function initMenu(){
		var obj = document.getElementById('listMenu');
		var linkCounter=0;
		var aTags = obj.getElementsByTagName('A');
		var activeMenuItem = false;
		var activeMenuLink = false;
		var thisLocationArray = location.href.split(/\//);
		var fileNameThis = thisLocationArray[thisLocationArray.length-1];
		if(fileNameThis.indexOf('?')>0)fileNameThis = fileNameThis.substr(0,fileNameThis.indexOf('?'));
		if(fileNameThis.indexOf('#')>0)fileNameThis = fileNameThis.substr(0,fileNameThis.indexOf('#'));
		for(var no=0;no<aTags.length;no++){
			var parent = aTags[no].parentNode;
			var subs = parent.getElementsByTagName('UL');
			if(subs.length>0){
				aTags[no].onclick = showHideSub;	
				linkCounter++;
				aTags[no].id = 'aLink' + linkCounter;
			}	
			if(aTags[no].href.indexOf(fileNameThis)>=0 && aTags[no].href.charAt(aTags[no].href.length-1)!='#'){				
				if(aTags[no].parentNode.parentNode){								
					var parentObj = aTags[no].parentNode.parentNode.parentNode;
					var a = parentObj.getElementsByTagName('A')[0];
					if(a.id && !activeMenuLink){
						activeMenuLink = aTags[no];
						activeMenuItem = a.id;
					}
				}
			}		
		}		
		if(activeMenuLink){
			activeMenuLink.className='activeMenuLink';
		}
		if(activeMenuItem){
			if(document.getElementById(activeMenuItem))showHidePath(document.getElementById(activeMenuItem));	
		}
	}
	window.onload = initMenu;
