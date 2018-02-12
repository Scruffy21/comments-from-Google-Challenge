

function sendData () {

    console.log("in sendData function");
    const xmlhttp = new XMLHttpRequest();
    nick = nameInput.value;
    const comment = commentInput.value;
    //check if required values have been input
    if (nick == "") {
        errShow(nameInput);
        return false;
    }
    else if (comment == "")
    {
        errShow(commentInput);
        return false;
    }
    const body = document.getElementsByTagName("body")[0];
    const website = parseUrl(document.getElementById("urlInput").value);

    const photo = document.getElementById("photoInput").files[0];

    const data = new FormData();
    data.append("name", nick);
    data.append("website", website);
    data.append("comment", comment);
    if (photo) {
        data.append("photo", photo, photo.name);
    }
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            body.classList.remove("wait");
            submit.classList.remove("wait");
            successMsg();
            resetInputs();
            prependCmnt(this.responseText);
        }
    }


    xmlhttp.open("POST", "assets/lib/processComment.php");
    // xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(data);
    body.classList.add("wait");
    submit.classList.add("wait");
}

// add prefix (html://www.) to website specified by user, if needed.
function parseUrl(url) {
    if (url === "") {
        return url;
    }
    else {
        const urlArr = url.split(".");
        if (urlArr[0].indexOf("http") !== -1) {
            return url;
        }
        else if (urlArr[0].indexOf("www") !== -1) {
            return "http://" + url;
        }
        else {
            return "http://www." + url;
        }
    }
}

function resetInputs() {
    photoPreview.innerHTML = '<i class="far fa-file-image"></i>';
    photoInput.value = "";
    nameInput.value = "";
    urlInput.value = "";
    commentInput.value = "";
}

//add comment posted to the beginning of the page
function prependCmnt(resp) {
    const rObj = JSON.parse(resp);
    let txt = "<div class='cmnt-info'><img src='assets/flags/" + rObj.flag + ".png' class='flag' title='" + rObj.country + "'> <span class='user-name'>";

    if (rObj.website == "") {
        txt += rObj.name + "</span>";
    }
    else {
        txt += "<a href='" + rObj.website + "'>" + rObj.name + "</a></span>";
    }
    txt += "<span class='datetime'><span class='time'>" + rObj.time + "</span><span class='date'>" + rObj.date + "</span></span></div><div class='user-cmnt'><img src=" + rObj.photo + " class='user-img'>" + rObj.comment + "</div>";
    const temp = document.createElement("div");
    temp.classList.add('cmnt');
    temp.innerHTML = txt;

    // console.log(txt);
    // temp.innerHTML = txt;
    // console.log(temp.innerHTML);
    const pr = document.getElementById("commentsSection");
    const bf = pr.firstChild;
    pr.insertBefore(temp, bf);
    // pr.appendChild(temp);
    // console.log("inserted or at least tried");
}

function successMsg() {
    const modal = document.getElementById("cmntPosted");
    modal.style.display = "block";
    setTimeout(function() {
        modal.style.display = "none";
    }, 2000)
}