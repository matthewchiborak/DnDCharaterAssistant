let createRollString = function()
{
	let resultText = "/r 1d20";
	
	document.querySelector("#result").innerHTML = resultText;
	
	copyToClipboard(resultText);
}

let copyToClipboard = function(text) 
{
	window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}