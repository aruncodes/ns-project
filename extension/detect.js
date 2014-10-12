(function () {

	var insertedNodes = [];
	

	var checkContents = function (e) {

		//push nodes to global var
		insertedNodes.push(e.target);

		//check in inserted Nodes
		console.log(insertedNodes); 
		// console.log('loaded new child');
		// alert();
		// console.log(e.target);

		if( isVulnerable(e.target.outerHTML)) {
			//alert('isVulnerable');
			// console.log(e.target.innerHTML + ' is Vulnerable');
			// console.log(e.target.style.opacity);
			// console.log(e.target);
			// e.target.style.opacity=1;
			walk(e.target,function() { 
				if(this.tagName === "IFRAME") {
					this.style.opacity=1;
					//console.log(this.tagName);
				}
			});
		}
	};

	function isVulnerable(data) {
		var iFramePat = /<\s*iframe/i;

		if( iFramePat.test(data) )
			return true;
		
		return false;
	}

	document.addEventListener("DOMNodeInserted", checkContents, false);

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