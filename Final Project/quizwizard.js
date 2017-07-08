<!--

    var res = "";

    /* Function is executed after the page loads, display all the quizzes and
    it call ajax to see if there are updates ever 1s*/
    function init() {
        checkUpdate();
		setInterval(checkUpdate2, 1000);		
    }
		

    /*This function call ajax to display all the quiz names and details*/
    function checkUpdate()
    {
            var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/quizwizard.php", true); 
            
			xhr.onreadystatechange = function () 
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					res = xhr.responseText;
                    display_result(res);   
				}
			}	
  
			xhr.send(null);
    }
    
    function checkUpdate2(){
 var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/quizwizard.php", true); 
            
			xhr.onreadystatechange = function () 
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					var res2 = xhr.responseText;
                    display_result2(res2);   
				}
			}	
  
			xhr.send(null);    }
    

   /* Display the response text in a table */
    function display_result(result2){
        
        var listquizzes = document.getElementById("listquizzes");
        var newtable = document.createElement("TABLE");
        
        /* Create table headers */
        var newtr = document.createElement("tr");
        var newth = document.createElement("th");

        newth.innerHTML="Quiz Name";
        newtr.appendChild(newth);

        var newth = document.createElement("th");
        newth.innerHTML="Created Date";
        newtr.appendChild(newth);

        var newth = document.createElement("th");
        newth.innerHTML="Created By";
        newtr.appendChild(newth);
                     
        var newth = document.createElement("th");
        newth.innerHTML="View Highscore";
        newtr.appendChild(newth);
        
        var newth = document.createElement("th");
        newth.innerHTML="View Comments";
        newtr.appendChild(newth);
                             
        listquizzes.appendChild(newtr);

        /* Split the response text into an array of all the quizzes */
        var result=result2.split(",");
        
        for (var i = 0; i < result.length-1; i++) {
                
            var newtr = document.createElement("tr");
            /* Set the color depending on the row */
            if (i%2 == 0) {newtr.setAttribute("class", "even");}
            else {newtr.setAttribute("class", "odd");}
            
            var newtd = document.createElement("td");
           
            // Display the quiz's name and directly link it to the page where you can take the quiz
            newtd.innerHTML= "<a href='http://pic.ucla.edu/~leprekhanh/final_project/takequiz?qname=" + result[i].split("/")[0] + "'>" + result[i].split("/")[1] + "</a>";
            newtr.appendChild(newtd);
                     
            var newtd = document.createElement("td");
            
            // Display the quiz's creation date
            newtd.innerHTML=result[i].split("/")[3];
            newtr.appendChild(newtd);
                     
            var newtd = document.createElement("td");
            
            // Display the quiz's creator
            newtd.innerHTML=result[i].split("/")[2];
            newtr.appendChild(newtd);
                   
            // Display the high score link
            var newtd = document.createElement("td");
            newtd.innerHTML="<a href='http://pic.ucla.edu/~leprekhanh/final_project/viewhs.html?hs=" + result[i].split("/")[0] + "hs'>Highscore</a>";
            newtr.appendChild(newtd);
                
            // Display the link to comment
            var newtd = document.createElement("td");
            newtd.innerHTML="<a href='http://pic.ucla.edu/~leprekhanh/final_project/comment.html?qname=" + result[i].split("/")[0] + "'>Comments</a>";
            newtr.appendChild(newtd);
                     
            listquizzes.appendChild(newtr);
              
            }
        }
        
    /* Check if the new response text is different from the old one,
        if it is, the function proceeds to delete all the nodes of the table and
        append the new response text onto the table. This function is called every second to 
        check if new quizzes are made and to display them */
    function display_result2(result22) {
        
        //Compare response texts lengths to see if the new one is newer
       if (res.length < result22.length) {
           
            var listquizzes = document.getElementById("listquizzes");
            
           // Remove all the nodes of the table
            while (listquizzes.hasChildNodes()) 
            {
            listquizzes.removeChild(listquizzes.lastChild);
            }
        
           /*Recreate the table headers*/
            var newtr = document.createElement("tr");
            var newth = document.createElement("th");

            newth.innerHTML="Quiz Name";
            newtr.appendChild(newth);

            var newth = document.createElement("th");
            newth.innerHTML="Created Date";
            newtr.appendChild(newth);

            var newth = document.createElement("th");
            newth.innerHTML="Created By";
            newtr.appendChild(newth);

            var newth = document.createElement("th");
            newth.innerHTML="View Highscore";
            newtr.appendChild(newth);

            var newth = document.createElement("th");
            newth.innerHTML="View Comments";
            newtr.appendChild(newth);
            listquizzes.appendChild(newtr);
           
           /* Loop through the new response text and 
           display all the events including the new event(s)*/
            var resultss=result22.split(",");
            for (var i = 0; i < resultss.length-1; i++)
            {
                var newtr = document.createElement("tr");
                
                //Display correct color for the row
                if (i%2 == 0) 
                {
                    newtr.setAttribute("class", "even");
                }
                else {
                    newtr.setAttribute("class", "odd");
                }
                
                /* Same logic as the previous function, display the quiz names and its details */
                var newtd = document.createElement("td");
                newtd.innerHTML= "<a href='http://pic.ucla.edu/~leprekhanh/final_project/takequiz?qname=" + resultss[i].split("/")[0] + "'>" + resultss[i].split("/")[1] + "</a>";
                newtr.appendChild(newtd);
                     
                var newtd = document.createElement("td");
                newtd.innerHTML=resultss[i].split("/")[3];
                newtr.appendChild(newtd);
                     
                var newtd = document.createElement("td");
                newtd.innerHTML=resultss[i].split("/")[2];
                newtr.appendChild(newtd);
                                     
                var newtd = document.createElement("td");
                newtd.innerHTML="<a href='http://pic.ucla.edu/~leprekhanh/final_project/viewhs.html?hs=" + resultss[i].split("/")[0] + "hs'>Highscore</a>";
                newtr.appendChild(newtd);
                
                var newtd = document.createElement("td");
                newtd.innerHTML="<a href='http://pic.ucla.edu/~leprekhanh/final_project/comment.html?qname=" + resultss[i].split("/")[0] + "'>Comments</a>";
                newtr.appendChild(newtd);
                     
                listquizzes.appendChild(newtr);
              
            }
            
        }
            /* Update the variable res which contained the first response text, 
            this is so that subsequent changes to the new response text can be compared correctly */
            res = result22;
    }

-->

