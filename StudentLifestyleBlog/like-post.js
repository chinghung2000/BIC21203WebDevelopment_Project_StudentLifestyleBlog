var post= document.getElementById("post");
post.addEventListener("click", function(){
    var commentBoxValue= document.getElementById("comment-box").value;
 
    var li = document.createElement("li");
    var text = document.createTextNode(commentBoxValue);
    li.appendChild(text);
    document.getElementById("unordered").appendChild(li);
 
});
function myFunction(x) {
    x.classList.toggle("fa-thumbs-down");
  }
  function addLike(e){
    let count = Number(e.nextElementSibling.innerText) + 1;
    e.nextElementSibling.innerText = count;
  }