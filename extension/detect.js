(function () {

	var insertedNodes = [];
    var vulnerableNodes = [];

    var closeWarnings = function() {
        warningDiv.style.width = "0px";
        warningDiv.style.height = "0px";
        warningDiv.style.display="none";

        exitDiv.style.width = "0px";
        exitDiv.style.height = "0px";
        exitDiv.style.display="none";
    }

    var warningDiv;
    /*var warningDiv = document.createElement('div'); 
    warningDiv.id = 'warningDiv';
    warningDiv.className = 'warningDiv';
    warningDiv.innerHTML = "AJAX-DEFENDER <br /> <br />\n";
    warningDiv.innerHTML += "WARNINGS <br />\n";
    */

    var exitDiv;
    /*var exitDiv = document.createElement('div'); 
    exitDiv.id = 'exitDiv';
    exitDiv.className = 'exitDiv';
    exitDiv.innerHTML = "<input type='button' value='X'/>";
    exitDiv.onclick = closeWarnings;
    */
        
    
    var warnCnt = 1;
    var showWarnings = function() {
        for(i = 0; i < vulnerableNodes.length; i++) {
            warningDiv.innerHTML += ""+ warnCnt+". "+vulnerableNodes[i]+"<br />";
            warnCnt++;
        }
    }

	var checkContents = function (e) {

		//push nodes to global var
		insertedNodes.push(e.target);

		//check in inserted Nodes
		//console.log(insertedNodes); 
		// console.log('loaded new child');
        // alert();
        // console.log(e.target);

        if( isVulnerable(e.target.outerHTML) ) {
            if(!document.getElementById('warningDiv')) {
                warningDiv = document.createElement('div'); 
                warningDiv.id = 'warningDiv';
                warningDiv.className = 'warningDiv';
                warningDiv.innerHTML = "AJAX-DEFENDER <br /> <br />\n";
                warningDiv.innerHTML += "WARNINGS <br />\n";
                document.body.appendChild(warningDiv);

                exitDiv = document.createElement('div'); 
                exitDiv.id = 'exitDiv';
                exitDiv.className = 'exitDiv';
                exitDiv.innerHTML = "<input type='button' value='X'/>";
                exitDiv.onclick = closeWarnings;
                document.body.appendChild(exitDiv);
            }
		//alert('isVulnerable');
			// console.log(e.target.innerHTML + ' is Vulnerable');
			// console.log(e.target.style.opacity);
			// console.log(e.target);
			// e.target.style.opacity=1;
			walk(e.target,function() { 
                //console.log("VULNERABLE"+this.tagName);
			if(this.tagName === "IFRAME") {
                    console.log("IFRAME caught: "+this.outerHTML);
					this.style.opacity=1;
                    vulnerableNodes.push("An iFrame was enabled via AJAX, made opaque");
                    return false;
				}
                else if(this.tagName === "SCRIPT") {
                    console.log("SCRIPT caught: "+this.outerHTML);
                    vulnerableNodes.push("A script was obtained via AJAX");
                    return false;
                }
                else {
                    //console.log("Event caught: "+this.outerHTML);
                    /*for (var i = 0, atts = this.attributes, n = atts.length; i < n; i++){
                        console.log("andi"+atts[i].nodeName);
                    }*/
                    if(this.attributes !== undefined) {
                        for (var i = 0, atts = this.attributes, n = atts.length; i < n; i++){
                            var onEventPat = /on.+/i
                            if( onEventPat.test(atts[i].nodeName) && atts[i].value.length != 0)
                                vulnerableNodes.push("Tag '"+this.tagName+"' runs a script '"+atts[i].value+"' , using events");
                        }
                    }

	
                    //return false;
                }
                /*if(this.tagName === "SCRIPT") {
                  console.log("SCRIPT caught: "+this);
                  vulnerableNodes.push("Script was obtained via AJAX, please take caution");
                  return false;
                }*/
			});
            //console.log(vulnerableNodes);
            showWarnings();
		}
	};

	function isVulnerable(data) {
		var iFramePat = /<\s*iframe/i;
        var scriptPat = /<\s*script/i;
        var onEventPat = /<.*\s+on[^\s]+\s*=[\'\"].+[\'\"].*>/i;

		if( iFramePat.test(data) )
			return true;
        if( scriptPat.test(data) )
            return true;
        if( onEventPat.test(data) )
            return true;

		return false;
	}

	document.addEventListener("DOMNodeInserted", checkContents, false);
    //showWarnings();

	// chrome.webRequest.onCompleted.addListener(function() {console.log(insertedNodes); } );
	// window.setInterval(function () { 
	// 	// console.log("printing nodes.");
		
	// },1000);

	function walk(node, callback) {
	  var skip, tmp;
	  var depth = 0;
	 
	  do {
	    if ( !skip ) {
	      skip = callback.call(node, depth) === false;
	    }
	 
	    if ( !skip && (tmp = node.firstChild) ) {
	      depth++;
	    } else if ( tmp = node.nextSibling ) {
	      skip = false;
	    } else {
	      tmp = node.parentNode;
	      depth--;
	      skip = true;
	    }
	 
	    node = tmp;
	 
	  } while ( depth > 0 );
	}

})();
