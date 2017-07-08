<!--

// Loop through the array to find the max frequency
function getMax (freq) {
    var max = freq[0];
    
    for (i = 0; i < freq.length; i++)
        {
            if (freq[i] > max)
                {
                    max = freq[i];
                }
        }
    return max;
}


function makeCloud() {
    var cloud_input = document.getElementById("tags").value;
    var unique_words = [];
    var frequency = [];
    
    //Convert the textarea string into an alphabetized array
    var cloud_sorted = cloud_input.split(" ");
    cloud_sorted.sort();
    
    //Count the frequency for each word and store it in a frequency array
    //Store the unique tags into a different array
    var starting_word = cloud_sorted[0];
    var count = 0;
    
    for (i = 0; i < cloud_sorted.length; i++)
        {
            if (starting_word === cloud_sorted[i])
                {
                    count++;
                }
            else 
            {
                //Store the current word and start counting the frequency of the next word
                unique_words.push(starting_word);
                starting_word = cloud_sorted[i];
                
                //Store the current count and reset it
                frequency.push(count);
                count = 1;
            }    
          
        }
    //Store the final values into respective arrays
    frequency.push(count); 
    unique_words.push(starting_word);

    //Get the max frequency
    var max_frequency = getMax(frequency);
    
    //Create a new div
    var bluediv = document.createElement("div");
    bluediv.innerHTML = "";
    bluediv.style.backgroundColor = "blue";
    bluediv.style.border = ".1em solid silver";
    bluediv.style.color = "silver";
    bluediv.style.fontFamily =  "serif";
    bluediv.style.fontsize = "x-large";
    bluediv.style.width = "450px";

    for (i = 0; i < unique_words.length; i++)
        {
            //Calculate the font size for each tag based on their frequency
            var multiplier = (frequency[i] / max_frequency) * 20;
            multiplier = Math.round(multiplier) + 15;
            
            //Create a span tag for each unique word with the corresponding font size
            span_tag = document.createElement("span");
            span_tag.style.fontSize = multiplier + "pt";
            
            var textnode = document.createTextNode(unique_words[i]);
            span_tag.appendChild(textnode);
    
            //Create an onclick attribute for each span tag and alerts a message containing each tag's frequency
            span_tag.onclick = function(num) {
            return function() { alert(unique_words[num] + ": " + frequency[num] + " occurrences"); }; }(i);

            //Create a text node containing an empty space
            var space = document.createTextNode(" ");
    
            //Append the span tags with a space between them in the blue div
            bluediv.appendChild(span_tag);
            bluediv.appendChild(space);    
        }

    //Replace the div in the body html with the blue div
    var olddiv = document.getElementsByTagName("div")[0];
	olddiv.parentNode.replaceChild(bluediv, olddiv);

}

// Save the textarea as a cookie
function saveCloud(){
    var input = document.getElementById("tags").value;
    document.cookie = input;
}

// Load the saved cookie into the textarea
function loadCloud(){
    var textarea = document.getElementById("tags");
    var cookie_array = document.cookie.split(";");
    var cookie = cookie_array[0];
    textarea.value = cookie;
}

// Clear the textarea
function clearArea(){
document.getElementById("tags").value = "";
}

-->

