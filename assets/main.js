//var portfolioPostsBtn = document.getElementById("portfolio-posts-btn");
var portfolioPostsContainer = document.getElementById("portfolio-posts-container");

if (portfolioPostsContainer) {
  
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', 'http://127.0.0.1/wordpress/wp-json/wp/v2/posts');
    ourRequest.onload = function() {
      if (ourRequest.status >= 200 && ourRequest.status < 400) {
        var data = JSON.parse(ourRequest.responseText);
      createHTML(data);
     // portfolioPostsBtn.remove();
      } else {
        console.log("We connected to the server, but it returned an error.");
      }
    };
    ourRequest.onerror = function() {
      console.log("Connection error");
    };

    ourRequest.send();
  };

function createHTML(postsData){
  var ourHTMLString = '';
  for (i = 0; i < postsData.length ; i++){
    ourHTMLString += '<h2>' + postsData[i].title.rendered  + '</h2>'
     ourHTMLString += postsData[i].content.rendered ;
  }
  portfolioPostsContainer.innerHTML = ourHTMLString;


}

// Quick Add Post AJAX
var quickAddButton = document.querySelector("#quick-add-button");

if(quickAddButton){
  quickAddButton.addEventListener("click", function() {
    var ourPostData = {
      "title": document.querySelector('.admin-quick-add [name="title"]').value,
     "content": document.querySelector('.admin-quick-add [name="content"]').value,
     "status": "publish"
    }
    var createPost = new XMLHttpRequest();
    createPost.open("POST", magicalData.siteURL + "/wp-json/wp/v2/posts");
    createPost.setRequestHeader("X-WP-Nonce", magicalData.nonce);
    createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    createPost.send(JSON.stringify(ourPostData));
    createPost.onreadystatechange = function() {
      if (createPost.readyState == 4) {
        if (createPost.status == 201) {
          document.querySelector('.admin-quick-add [name="title"]').value = '';
          document.querySelector('.admin-quick-add [name="content"]').value = '';
        } else {
          alert("Error - try again.");
        }
      }
    }
});
}

// Add  FOURNISSEUR
var quickAddButton1 = document.querySelector("#quick-add-button2");

if(quickAddButton1){
  quickAddButton1.addEventListener("click", function() {
 //   alert( document.querySelector('.admin-quick-add [name="code"]').value);
    var ourPostData = {
     "nom": document.querySelector('.admin-quick-add [name="nom"]').value,
     "code": document.querySelector('.admin-quick-add [name="code"]').value,
     "password": document.querySelector('.admin-quick-add [name="password"]').value,
     "login": document.querySelector('.admin-quick-add [name="login"]').value,
    }
    var createPost = new XMLHttpRequest();
    createPost.open("POST", "http://127.0.0.1/wordpress/wp-json/wp/v2/fournisseur");

    createPost.setRequestHeader("X-WP-Nonce", magicalData.nonce);
    createPost.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    createPost.send(JSON.stringify(ourPostData));
    createPost.onreadystatechange = function() {
      if (createPost.readyState == 4) {
        if (createPost.status == 200) {
         document.querySelector('.admin-quick-add [name="nom"]').value = '';
         document.querySelector('.admin-quick-add [name="code"]').value = '';
         document.querySelector('.admin-quick-add [name="password"]').value = '';
         document.querySelector('.admin-quick-add [name="login"]').value = '';
        } else {
          alert("Error.");
        }
      }
    }
});
}