<!--    
  var commenturl = "";
    var loadcomment = "";
    var textinput ="";
    var res3 = "";
    

    /* This function is called after the page is loaded*/
    function init(){   
        
    
    /*Get the query string*/
     var queryString = window.location.search || '';
        var key_pairs = [];
        var qs = {};
        queryString = queryString.substr(1);

        if (queryString.length){
        key_pairs = queryString.split('&');
        for (pairNum in key_pairs)
            {
                var key = key_pairs[pairNum].split('=')[0];
                if (!key.length) continue;
                if (typeof qs[key] === 'undefined')
                qs[key] = [];
                qs[key].push(key_pairs[pairNum].split('=')[1]);
            }
        }
    
    /*Get the query string for qname to get the current quiz's name*/
    var newqstring = qs["qname"];
        
    /*Update consequent query string for the php file*/
    newqstring = "qname=" + newqstring;
    loadcomment = newqstring;
    
    //Update the correct links to go to the highscore or take the quiz depending on which quiz the user is on*/
    var retakelink = "http://pic.ucla.edu/~leprekhanh/final_project/takequiz.html?qname=" + loadcomment.substring(6);
    document.getElementById("takequiz").setAttribute("href", retakelink);    
    var hslink = "http://pic.ucla.edu/~leprekhanh/final_project/viewhs.html?hs=" + loadcomment.substring(6) +"hs";
    document.getElementById("highscore").setAttribute("href", hslink);
        
    textinput = document.getElementById("newcomment").value;

    loadComments(); /*Load previously posted comments from the database*/
    setInterval(checkUpdate, 3000); /*Check for new comment updates every 3s*/
    }

    /* Add a new comment to the database */
    function newcomment(){
        textinput = document.getElementById("newcomment").value;
        var user = document.getElementById("commentuser").value;
        
        //Update the commenturl to send it to the php file to update the database with the new comment*/
        commenturl = loadcomment + "&user=" + user + "&comment=" + textinput;
    
        update(); /*Add new comment to database using Ajax*/
    }
    
    
    /* This function updates the database with the new comment using Ajax */
     function update()
    {
            var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/comment.php?" + commenturl, true); 
            
			xhr.onreadystatechange = function () 
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
                    /* Can use this part to alert and see if the new comment was updated */
					//res = xhr.responseText;
                    //alert(res);
				}
			}	
  
			xhr.send(null);
    }
    
    /* This function is called on when the page loads to load all the previously posted comments */
    function loadComments()
    {
         var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/comment.php?" + loadcomment, true); 
            
			xhr.onreadystatechange = function () 
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					res2 = xhr.responseText;
                    
                    //Update the h2 to inform user which quiz they're commenting on 
                    document.getElementById("commentname").innerHTML = "Comments on Quiz: " + res2.split("~")[0];
                    
                    load(res2.split("~")[1]);

				}
			}	
  
			xhr.send(null);
    }
    
    /* This function takes the response text and display the comments as list items */
    function load(res2){
        
        var listcomments = document.getElementById("comments");
        
        /* Remove all the current nodes in the list */
        while (listcomments.hasChildNodes()) 
            {
                listcomments.removeChild(listcomments.lastChild);
            }
        
        var com2 = res2.split(";");
        for (var i = 0; i < com2.length-1; i++)
            {
                var textnode = document.createTextNode(com2[i].split("/")[1]);

                var olnode = document.getElementById("comments");
        
                var newli = document.createElement("LI");
                var newol = document.createElement("OL");

                var user = com2[i].split("/")[0];

                user = user + " • " + com2[i].split("/")[2];
                var usernode = document.createTextNode(user);
                
                /* Append the poster and date posted to the LI element */
                newli.appendChild(usernode);
                /* Append the comment message to the OL element */
                newol.appendChild(textnode);
                newli.appendChild(newol);
                olnode.appendChild(newli);
            }
    }
    
    /* This function is called every 3s to update the page with new comments */
    function checkUpdate()
    {
         var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/comment.php?" + loadcomment, true); 
            
			xhr.onreadystatechange = function () 
			{
				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					res3 = xhr.responseText;
                                        
                    
                    if (res3.length > res2.length) 
                    {
                        load(res3.split("~")[1]);
                    }  
				}
			}	
  
			xhr.send(null);
    }
    
    /* Get the values given the cookie's name */
    function extract(cookie_name)
    {
        var cookie_array = document.cookie.split("; ");
        
        var values = new Array();
        
        for (var i=0; i < cookie_array.length; i++)
        {	
            var cn = cookie_array[i].split("=")[0];
            if (cn == cookie_name) 
                {
                    values = cookie_array[i].split("=")[1].split(",");
                }
        }

        return values;
    }
    
   /* Save the current input as a cookie */
    function save() {
        var qnamecomment = loadcomment.substring(6);
        var input = document.getElementById("newcomment").value;
        
        //insert the saved input respectively with the current quiz's name
        var input = qnamecomment + "=" + input + ";";
        
        document.cookie = input;
    }

    //Load the saved cookie into the textarea
    function loadsaved(){
        
        /* Only load the saved comment for the respective quiz
            For example, user saved comment for quiz1 and another comment for quiz2
            This makes sure that if user is on the quiz1 page, only the saved comment corresponding to quiz1 is loaded
        */
        var testarray = extract(loadcomment.substring(6));

        var textarea = document.getElementById("newcomment");

        textarea.value = testarray;
    }    
   
    -->