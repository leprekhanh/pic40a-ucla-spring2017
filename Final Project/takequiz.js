<!--    
    var omg="";
    var wao ="";
    var result2="";
    var result="";
    var countq = 1;
        var starting = 0;
        var startingdivwidth = 0;

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
    
    var newqstring = params['qname'];
    var wao = newqstring;

    newqstring = "qname=" + newqstring;
    omg = newqstring;
    document.getElementById("qname").value = wao;
    
    hi(omg);
    
    
}
    
    
    function hi(omg){
        var xhr = new XMLHttpRequest();

            xhr.open("GET", "http://pic.ucla.edu/~leprekhanh/final_project/takequiz.php?" + omg,true); 
            
			xhr.onreadystatechange = function () 
			{

				if (xhr.readyState == 4 && xhr.status == 200) 
				{

				    result2 = xhr.responseText;
                    var res = result2.split("|");
                    
                    document.getElementById("tablecaption").innerHTML = "Quiz: " + res[0];
                    for (var i = 1; i < res.length-1; i++)
                        {
                            var newtr = document.createElement("tr");
                             var newtd = document.createElement("td");
                             var ax = countq;
                            
                            newtd.innerHTML=res[i];
                    
                            newtr.appendChild(newtd);
                            var answerinput = document.createElement("input");
                            answerinput.setAttribute("name", ax);
                            answerinput.setAttribute("id", ax);
                            newtr.appendChild(answerinput);
                            document.getElementById("questionstable").appendChild(newtr);
                            
                            countq++;

                        } 
                     starting = (countq-1) * 15 + 1; //15s per question
                    document.getElementById("timerdiv").innerHTML = starting + "s";
                    
                }
			}	
  
			xhr.send(null);    
    }
    
    
      var count=0;
        var divObj; 

function move_it()
{
    
	var left_offset = divObj.style.width;
    left_offset = parseInt(left_offset);
    var totals = (countq-1)*15; //15s per question
    var width = startingdivwidth / totals;

    if (starting > -1)
    {
        starting--;
        document.getElementById("timerdiv").innerHTML = starting + "s";
        if (starting == 0)
            {
                document.getElementById("timerdiv").style.backgroundColor = "white";

                var timeout_msg = document.createTextNode("Time's out! Please enter your name and submit!");
                var timeout = document.createElement("p");
                timeout.style.color="red";
                timeout.appendChild(timeout_msg);
               document.getElementById("container").appendChild(timeout);
                for(var i = 1; i <= countq; i++) 
                {
                document.getElementById(i).readOnly = true;
                }

            }
    }
    

    if (left_offset > 0){

	     left_offset = left_offset - width;
        divObj.style.width = left_offset + "px";
        setTimeout("move_it()",1000);

        }


}
        
        function start()
        {
            document.getElementById("questionstable").style.visibility = "visible";
            document.getElementById("timerdiv").style.visibility = "visible";
            document.getElementById("hidesubmit").style.visibility = "visible";
    
            divObj = document.getElementById("timerdiv");
            startingdivwidth = (countq-1) * 15 * 4;
            var divwidth = startingdivwidth + "px";
            divObj.style.width = divwidth;
            move_it(); 
            
        }
    -->