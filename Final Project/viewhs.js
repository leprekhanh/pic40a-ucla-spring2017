<!--    
    var omg="";
    var result2="";
    var result="";
function init(){
    var queryString = window.location.search || '';
    var keyValPairs = [];
    var params      = {};
    queryString     = queryString.substr(1);

    if (queryString.length)
    {
   keyValPairs = queryString.split('&');
   for (pairNum in keyValPairs)
    {
      var key = keyValPairs[pairNum].split('=')[0];
      if (!key.length) continue;
      if (typeof params[key] === 'undefined')
         params[key] = [];
      params[key].push(keyValPairs[pairNum].split('=')[1]);
    }
    }
    
    var newqstring = params['hs'];
   
 

    newqstring = "hs=" + newqstring;
    omg = newqstring;
    
     var commentlink = "http://pic.ucla.edu/~leprekhanh/final_project/comment.html?qname=" + omg.substring(3, omg.length-2);
    document.getElementById("comment").setAttribute("href", commentlink);

    var retakelink = "http://pic.ucla.edu/~leprekhanh/final_project/takequiz.html?qname=" + omg.substring(3, omg.length-2);
    document.getElementById("retake").setAttribute("href", retakelink);
    
   
    stuff(newqstring);
    
    setInterval(hi, 10);
    }
    
    function hi(){
        var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/viewhs.php?" + omg,true); 
            
			xhr.onreadystatechange = function () 
			{

				if (xhr.readyState == 4 && xhr.status == 200) 
				{

				    result2 = xhr.responseText;
                    document.getElementById("hsname").innerHTML = "Highscore Table: " + result2.split("~")[0];
                    result2 = result2.split("~")[1];
                    display(result2); 
				}
			}	
  
			xhr.send(null);    
    }
   
    
		function stuff(query_string) 
		{

			var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/viewhs.php?" + query_string,true); 
            
			xhr.onreadystatechange = function () 
			{

				if (xhr.readyState == 4 && xhr.status == 200) 
				{
					 result = xhr.responseText;
                   result = result.split("~")[1];
                    display_result(result); 
				}
			}	
  
			xhr.send(null);
		}
    

    function display_result(result){
       var aresult = result.split(";");
        
        for (var i = 0; i < aresult.length-1; i++)
            {
                
                var presult = aresult[i].split("/");
                
                var tble = document.getElementById("hstable");
                var newtr = document.createElement("tr");
                var newtd = document.createElement("td");
                newtd.innerHTML= "<b>No. " + (i+1)+ "</b>";
                newtr.appendChild(newtd);
                
             
                    for (var j = 0; j < presult.length-1; j++)
                    {
                    var newtd = document.createElement("td");
                    newtd.innerHTML=presult[j];
                    newtr.appendChild(newtd);
                   }                  


             
                
                tble.appendChild(newtr);
                
            }
    }
    
    
        
         function display(result2){
            
             var aresult = result2.split(";"); //new one
             var rs2 = result.split(";"); //first one
             
             if (rs2.length != aresult.length)
                 {
                    var list = document.getElementById("hstable");

                      while (list.hasChildNodes()) {
                        list.removeChild(list.lastChild);
                        }
                     
                  var newtr = document.createElement("tr");
                      var newth = document.createElement("th");

                      newth.innerHTML="Rank";
                      newtr.appendChild(newth);
                    
                      var newth = document.createElement("th");
                     newth.innerHTML="Name";
                     newtr.appendChild(newth);
                     
                var newth = document.createElement("th");

                newth.innerHTML="Score";
                newtr.appendChild(newth);
                     
                var newth = document.createElement("th");

                newth.innerHTML="Time Taken";
                newtr.appendChild(newth);
                     
                list.appendChild(newtr);

                     
               var hello = result2.split(";");
        
        for (var i = 0; i < hello.length-1; i++)
            {                
                var presult = hello[i].split("/");
                
                
                var tble = document.getElementById("hstable");
                var newtr = document.createElement("tr");
                 var newtd = document.createElement("td");
                newtd.innerHTML= "<b>No. " + (i+1)+ "</b>";
                newtr.appendChild(newtd);
            
               for (var j = 0; j < presult.length-1; j++){
                   
                var newtd = document.createElement("td");
                newtd.innerHTML=presult[j];
                newtr.appendChild(newtd);
                   }
               
                tble.appendChild(newtr); 
            }
            
                result = result2;
                
                }
                     
    

            }
    
    -->