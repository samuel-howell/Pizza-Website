 
  function changeStatusBtn() {
      $("button").click
      (
        function() 
        { 
          //  "this" means that it will change the current HTML element that is clicked
          $(this).html("Completed");                  //  this jQuery changes the text in the element
          $(this).css("background-color", "#05FF00");   //  this jQuery changes the  background color of the element
        }
      );
  }
     
  function createDynamicIDs() 
  {
    var statusBtnArr = document.querySelectorAll("#statusBtn"); //get all the td's with the statusBtn class and place in an array


    for (var i = 0; i < statusBtnArr.length; ++i)
    {
      statusBtnArr[i].setAttribute("id", i);  //  change the id of that status button to its unique val (i)
    }   
  }

  createDynamicIDs();  //  calls the function directly after the page is loaded, giving each row its own unique id

