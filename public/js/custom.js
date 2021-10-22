function forceLower(strInput){
    strInput.value=strInput.value.toLowerCase()
}

document.getElementById('year').appendChild(document.createTextNode(new Date().getFullYear()))