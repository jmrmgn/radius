var valueContainer = document.getElementById("valueContainer");
var operator = document.getElementById("operator");
var selectAttr = document.getElementById("selectAttr");
var txtSearch = document.getElementById("txtSearch");

selectAttrHandler();

if ( txtSearch !== null ) {
   txtSearch.addEventListener("input", getUsers);
}

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

function getUsers() {
   var xhr = new XMLHttpRequest();

   xhr.open("POST", "controllers/search.php", true);
   xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

   xhr.onload = function() {
      if ( xhr.status == 200 ) {
         var users = JSON.parse(this.responseText);
         var output = '';
         var counter = 1;
         
         if ( users.length > 0 ) {
            for ( var i in users ) {
               output += `
                  <tr>
                     <td>${counter}</td>
                     <td>${users[i].username}</td>
                     <td>${users[i].attribute}</td>
                     <td>${users[i].op}</td>
                     <td>${users[i].value}</td>
                     <td>
                        <a href="edit.php?id=${users[i].id}&type=${ users[i].op == ':=' ? 1 : 2 }">Edit</a>
                        <a href="delete.php?id=${users[i].id}">Delete</a>
                     </td>
                  </tr>
               `
               counter += 1;
            }
         }
         else {
            output = `
               <tr>
                  <td colspan="6">No users found...</td>
               </tr>
            `
         }
         
         document.getElementById("usersData").innerHTML = output;
         
      }
      else {
         console.log(this.responseText);
      }
   }

   xhr.send("txtSearch="+txtSearch.value);
}