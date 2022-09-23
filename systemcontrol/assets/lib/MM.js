function Paging_CheckAll(objCheckHeader,txtCheckBoxFirstName,intTotalItems) {
	if(intTotalItems>0)
		for(i=1;i<=intTotalItems;i++)
			document.getElementById(txtCheckBoxFirstName+i).checked = objCheckHeader.checked;			
	return true;
}
function Paging_CheckAllHandle(objCheckHeader,txtCheckBoxFirstName,intTotalItems) {
	var isCheckedAll = true;
	if(intTotalItems>0)
		for(i=1;i<=intTotalItems;i++)
			if(!document.getElementById(txtCheckBoxFirstName+i).checked) 
				isCheckedAll = false;
	objCheckHeader.checked = isCheckedAll;
	return true;
}
function Paging_CountChecked(txtCheckBoxFirstName,intTotalItems) {
	var intChecked = 0;
	if(intTotalItems>0)
		for(i=1;i<=intTotalItems;i++)
			if(document.getElementById(txtCheckBoxFirstName+i).checked) 
				intChecked ++;
	return intChecked ;
}
function Paging_CheckedThisItem(objCheckHeader,indexing,txtCheckBoxFirstName,intTotalItems) {
	if(intTotalItems>0)
		for(i=1;i<=intTotalItems;i++)
			if(i==indexing) {
				document.getElementById(txtCheckBoxFirstName+i).checked = true;
			} else {
				document.getElementById(txtCheckBoxFirstName+i).checked = false;
			}
	objCheckHeader.checked = false;
	return true;
}
function isBlank(myObj) { if(myObj.value=='') { return true; } return false; }
function isNumber(myObj) { return !isNaN(myObj.value*1) }
function isEqual(myObj1,myObj2) {	if(myObj1.value==myObj2.value) { return true; }	return false;}
function  check_num(e){
   var keyPressed;
   if(window.event){
      keyPressed = window.event.keyCode; // IE
       if ((keyPressed < 48) || (keyPressed > 57)) {
			alert('input number only.');
		   window.event.returnValue = false;
	   }
   }else{
      keyPressed = e.which; // Firefox      
       if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=8) && (keyPressed!=0) ) {
			alert('input number only.');
		   keyPressed = e.preventDefault();
	   }
    }
}
function chkPassKey(data){
	var upperCase= new RegExp('[A-Z]');
	var lowerCase= new RegExp('[a-z]');
	var numbers = new RegExp('[0-9]');
	var xsp = new RegExp('[!@#$%^&*()_+-,/?<>.:;]');
	//if(/^[a-zA-Z0-9]*$/.test(data) == true) {
	if(data.match(upperCase) && data.match(lowerCase) && data.match(numbers)) {
		//if(check(data) == false){
		if(!data.match(xsp)){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

function check_numalert(e,idname){
   var keyPressed;
   if(window.event){
      keyPressed = window.event.keyCode; // IE
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT'); 
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0)) {
		   jAlert('input number only.', 'Alert Dialog',function(){
				$('#'+idname).focus();																 
			});
			//alert('input number only.');
			window.event.returnValue = false;
		}
	  }
   }else{
      keyPressed = e.which; // Firefox  
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT'); 
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0)) {
			jAlert('input number only.', 'Alert Dialog',function(){
				$('#'+idname).focus();																 
			});
			//alert('input number only.');
			keyPressed = e.preventDefault();
		}
	  }
    }
}

function check_numalertthis(e,t){
   var keyPressed;
   if(window.event){
      keyPressed = window.event.keyCode; // IE
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT'); 
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0) && (keyPressed!=13)) {
		   jAlert('input number only.', 'Alert Dialog',function(){
				$(t).focus();																 
			});
			//alert('input number only.');
			window.event.returnValue = false;
		}
	  }
   }else{
      keyPressed = e.which; // Firefox  
	  if((keyPressed==97 && e.ctrlKey === true) || (e.ctrlKey == true && (keyPressed == '118' || keyPressed == '86')) || (e.ctrlKey == true && (keyPressed == '99' || keyPressed == '67')) || (e.ctrlKey == true && (keyPressed == '120' || keyPressed == '88'))){
		 //alert('TT'); 
	  }else{
		if (((keyPressed < 48) || (keyPressed > 57)) && (keyPressed!=45) && (keyPressed!=46) && (keyPressed!=8) && (keyPressed!=0) && (keyPressed!=13)) {
			jAlert('input number only.', 'Alert Dialog',function(){
				$(t).focus();																 
			});
			//alert('input number only.');
			keyPressed = e.preventDefault();
		}
	  }
    }
}

function isDate(txtDate){
    var currVal = txtDate;
    if(currVal == '')
        return false;

    var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null) 
        return false;

    //Checks for dd/mm/yyyy format.
    dtMonth = dtArray[3];
    dtDay= dtArray[1];
    dtYear = dtArray[5];        

    if (dtMonth < 1 || dtMonth > 12) 
        return false;
    else if (dtDay < 1 || dtDay> 31) 
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31) 
        return false;
    else if (dtMonth == 2) 
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap)) 
                return false;
    }
    return true;
}

function formatNumber(s) {
	var $this = s;
	var num = $this.val().replace(/,/g, '');
	$this.val(num.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
}

function addCommas(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function getNum(val) {
   if (isNaN(val)) {
     return 0;
   }
   return val;
}
// -->