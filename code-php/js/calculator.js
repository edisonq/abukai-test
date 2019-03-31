window.onload = function() {
  var newNumber = '';
  var oldNumber = 0;
  var prevOperation = '';
  function loadIframe(iframeName, url) {
    var $iframe = $('#' + iframeName);
    if ( $iframe.length ) {
        $iframe.attr('src',url);   
        return false;
    }
    return true;
  }


  // NOT using jQuery sample
  document.addEventListener('keydown', function(event) {
    let keysAccepted = ['1','2','3','4','5','6','7','8','9','0']
    let operationsAccepted = ['+','-','=','Enter', 'Backspace']

    // to prevent the enter bug
    if (event.keyCode === 13) {
      // Cancel the default action, if needed
      event.preventDefault();
    }

      
    if (keysAccepted.includes(event.key) === true) {
      newNumber += event.key
      console.log(event.key)
      loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+newNumber)
    } else if (operationsAccepted.includes(event.key) === true) {
      if (event.key === '+') {
        if (prevOperation == '-') {
          oldNumber-= Number(newNumber)
        } else {
          oldNumber += Number(newNumber)
        }
        newNumber = ''
        prevOperation = '+'
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.key === '-') {
        if (prevOperation != '') {
          oldNumber -= Number(newNumber)
        } else if (prevOperation == '+'){
          oldNumber += Number(newNumber)
        } else {
          oldNumber = Number(newNumber)
        }
        newNumber = ''
        prevOperation = '-'
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.key === 'Backspace') {
        newNumber = ''
        oldNumber = 0
        prevOperation = ''
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.key === '=' || event.key == 'Enter') {
        if (prevOperation === '-') {
          oldNumber-= Number(newNumber)
        } else if (prevOperation === '+') {
          console.log('newNumber',newNumber)
          console.log('oldNumber', oldNumber)
          console.log('prev', prevOperation)
          oldNumber+= Number(newNumber)
          console.log(oldNumber)
        } 
        
        
        newNumber = ''
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
        oldNumber = 0
        prevOperation = '';
      }
    } else {
      console.log(event.key)
    }
  })
  document.addEventListener('click', function(event) {
    let keysAccepted = ['1','2','3','4','5','6','7','8','9','0']
    let operationsAccepted = ['add','subtract','clear','equals']
    if (keysAccepted.includes(event.target.id) === true) {
      newNumber += String(event.target.id)
      loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+newNumber)
    } else if (operationsAccepted.includes(event.target.id) === true) {
      if (event.target.id === 'add') {
        if (prevOperation == 'subtract') {
          oldNumber-= Number(newNumber)
        } else {
          oldNumber += Number(newNumber)
        }
        newNumber = ''
        prevOperation = 'add'
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.target.id === 'subtract') {
        if (prevOperation != '') {
          oldNumber -= Number(newNumber)
        } else if (prevOperation == 'add'){
          oldNumber += Number(newNumber)
        } else {
          oldNumber = Number(newNumber)
        }
        newNumber = ''
        prevOperation = 'subtract'
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.target.id === 'clear') {
        newNumber = ''
        oldNumber = 0
        prevOperation = ''
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
      } else if (event.target.id === 'equals') {
        if (prevOperation === 'subtract') {
          oldNumber-= Number(newNumber)
        } else if (prevOperation === 'add') {
          oldNumber+= Number(newNumber)
        } 
        loadIframe('iframe-viewer', BASEURLL+'calculator-viewer.php?number='+oldNumber)
        newNumber = ''
        oldNumber = 0
        prevOperation = '';
      }
    } else {
      console.log(event.target.id);
    }
    
  })

  

    
};
