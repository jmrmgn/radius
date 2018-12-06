var valueContainer = document.getElementById("valueContainer");
var operator = document.getElementById("operator");
var selectAttr = document.getElementById("selectAttr");

selectAttr.addEventListener("change", function() {
   var id = this.value;
   var output = '';
   
   switch (id) {
      case "1":
         output += `
            <input type="text" name="value" id="value" placeholder="Enter password"/>
         `
         break;
      
      case "2":
      case "7":
      case "8":
         output += `
            <input type="text" name="value" id="value" placeholder="Enter no. of hours"/>
         `
         break;

      case "3":
         output += `
            <small>From:</small> <input type="time" name="value_from" id="value_from"/>
            <small>To:</small> <input type="time" name="value_to" id="value_to"/>
         `
         break;

      case "4":
         output += `
            <input type="number" min="1" max="10" />
         `
         break;

      case "5":
         output += `
            <label>Datetime</label>
         `
         break;
      
      case "6":
         output += `
            <input type="text" value="Reject" disabled />
         `
         break;
      
      case "7":
         output += `
            <input type="text" value="Reject" disabled />
         `
         break;

      default:
         break;
   }

   valueContainer.innerHTML = output;
   if ( id == 7 || id == 8) {
      operator.value = "="
   }
   else {
      operator.value = ":="
   }

});