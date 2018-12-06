var valueContainer = document.getElementById("valueContainer");
var operator = document.getElementById("operator");
var selectAttr = document.getElementById("selectAttr");

selectAttrHandler();

selectAttr.addEventListener("change", selectAttrHandler);

   function selectAttrHandler() {
      var id = selectAttr.value;
      var output = '';
      
      switch (id) {
         case "1":
            output += `
               <input type="text" name="value" id="value" placeholder="Enter password" required/>
            `
            break;
         
         case "2":
         case "7":
         case "8":
            output += `
               <input type="text" name="value" id="value" placeholder="Enter no. of hours" required/>
            `
            break;

         case "3":
            output += `
               <small>From:</small> <input type="time" name="value_from" id="value_from" required/>
               <small>To:</small> <input type="time" name="value_to" id="value_to" required/>
            `
            break;

         case "4":
            output += `
               <input type="number" min="1" max="10" name="value" required />
            `
            break;

         case "5":
            output += `
               <input type="date" name="value_date" id="value_date" required/>
               <input type="time" name="value_time" id="value_time" required/>
            `
            break;
         
         case "6":
            output += `
               <input type="text" value="Reject" name="value" readonly />
            `
            break;

         default:
            break;
      }

      valueContainer.innerHTML = output;
      
      if ( selectAttr.value == 7 || selectAttr.value == 8) {
         operator.value = "="
      }
      else {
         operator.value = ":="
      }
   }