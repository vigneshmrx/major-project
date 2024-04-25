const dbName = localStorage.getItem("dbName");
const userName = localStorage.getItem("userName");
const userEmail = localStorage.getItem("emailID");

//undo and redo code begins here
const editableDiv = document.getElementById('editable-content-area');
const history = [];
let historyIndex = -1;
let imageInfoArray = [];
let coverImgPath = null;
let uploadedImgActionArea = document.getElementById("uploaded-image-action-area");
// let ci = "";

// const config = { attributes: true, childList: true, subtree: true };
// observer.observe(editableDiv, config);

// editableDiv.addEventListener('mouseup', saveState);
// editableDiv.addEventListener('paste', saveState);
// editableDiv.addEventListener('keydown', saveState);
//redo and undo code ends here

//controlling bold, italic, underline & strikethrough
const italicDiv = document.getElementById("italic-div");
const boldDiv = document.getElementById("bold-div");
const underlineDiv = document.getElementById("underline-div");
const strikethroughDiv = document.getElementById("strikethrough-div");
const unorderedListDiv = document.getElementById("unordered-list-div");
const orderedListDiv = document.getElementById("ordered-list-div");

italicDiv.addEventListener("click", function() {
    document.execCommand("italic", false, null); // Apply italic on button click
    italicDiv.classList.toggle("active");
    editableDiv.focus();
});

boldDiv.addEventListener("click", function() {
    document.execCommand("bold", false, null); // Apply bold on button click
    boldDiv.classList.toggle("active");
    editableDiv.focus();
});

underlineDiv.addEventListener("click", function() {
    document.execCommand("underline", false, null); // Apply underline on button click
    underlineDiv.classList.toggle("active");
    editableDiv.focus();
});

strikethroughDiv.addEventListener("click", function() {
    document.execCommand("strikethrough", false, null); // Apply strikethrough on button click
    strikethroughDiv.classList.toggle("active");
    editableDiv.focus();
});

orderedListDiv.addEventListener("click", () => {
    document.execCommand('insertOrderedList', false, null);
    orderedListDiv.classList.toggle("active");
    editableDiv.focus();
});

unorderedListDiv.addEventListener("click", () => {
    document.execCommand('insertUnorderedList', false, null);
    unorderedListDiv.classList.toggle("active");
    editableDiv.focus();
});



//controlling font size
let fontChange = document.getElementById("font-change-drop-down");

function increaseFontSize(newFontSize) {
    const selection = window.getSelection();
    if (!selection.rangeCount) return; // Exit if no selection
  
    const range = selection.getRangeAt(0);
  
    const span = document.createElement("span");
    span.style.fontSize = newFontSize
    range.surroundContents(span);

    selection.collapseToEnd(); // Collapse selection to the end for further editing
}

fontChange.addEventListener("change", (e) => {
    increaseFontSize(e.target.value);
});

//for uploading image
const imgUploadFun = (event) => {
    let img = document.createElement("img");
    // img.src = URL.createObjectURL(uploadImgBtn.files[0]);
    selectedFile = event.target.files[0];
    imageUrl = URL.createObjectURL(selectedFile);
    img.src = imageUrl;

    imagePath = "../major-project/images/user-images/" + dbName + "/" + selectedFile["name"];

    let imageInfoObj = {"imageUrl" : imageUrl, "imagePath" : imagePath};
    imageInfoArray.push(imageInfoObj);

    uploadedImgAreaOldContent = uploadedImageArea.innerHTML;

    uploadedImageArea.innerHTML = "";
    // uploadedImageArea.innerHTML = img;
    uploadedImageArea.appendChild(img);
}

const  makeOtherBtnVisible = () => {
    if (uploadedImgActionArea.firstElementChild.style.display == "none") {
        uploadedImgActionArea.firstElementChild.style.display = "block";
        // uploadedImgActionArea.lastElementChild.style.visibility = "visible";
    }
}

const deleteSelectedImg = () => {
    if (uploadedImageArea.firstChild.tagName == "IMG") {
        uploadedImageArea.innerHTML = "";
        uploadedImageArea.innerHTML = uploadedImgAreaOldContent;
        uploadImgBtn.value = "";
    }
}

const selectedImgFun = (uploadType) => {
    if (imageUrl !== null && imageUrl !== undefined) {
        let imageUploadPg = document.getElementById("image-upload-pg");

        imageUploadPg.style.zIndex = -150;
        imageUploadPg.style.visibility = "hidden";
        
        if (uploadType == "insert") {

            let div = document.createElement("div");
            div.style = "width: 100%; display: grid; place-items: center;"

            let img = document.createElement("img");
            img.src = imageUrl;
            img.style = "width: 60%;"

            div.appendChild(img);

            const selection = window.getSelection();
            const range = selection.getRangeAt(0);

            range.insertNode(div);

            range.setStartAfter(div);
            range.collapse(true);

            selection.removeAllRanges();
            selection.addRange(range);          

        }
        else {

            imageInfoArray.forEach((ele) => {
                if (ele["imageUrl"] == imageUrl) {
                    coverImgPath = ele["imagePath"];
                }
            })

            makeOtherBtnVisible();
        }
        

        uploadedImageArea.innerHTML = uploadedImgAreaOldContent;

        //uploading image to user's folder

        var formData = new FormData();
        formData.append("file", selectedFile);
        formData.append("folder_name", dbName);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../major-project/php-ajax/upload_img.php', true);

        xhr.send(formData);

    } else {
        showAlert("Please select an image before uploading!");
    }
}

function alignContent(sideName) {
    // Execute the command to align text
    document.execCommand(sideName, false, null);
}

let alignmentDropDown = document.getElementById("alignment-select");

alignmentDropDown.addEventListener("change", (e) => {
    alignContent(e.target.value);
});

let previousCursorPosition = 0;

editableDiv.addEventListener('mouseup', handleCursorPositionChange);
editableDiv.addEventListener('keyup', handleCursorPositionChange);
editableDiv.addEventListener('keydown', handleCursorPositionChange);

const highlightBold = (bol) => {
    if (bol) {
        if (!(boldDiv.classList.contains("active"))) {
            boldDiv.classList.add("active");
        }
    } else {
        if (boldDiv.classList.contains("active")) {
            boldDiv.classList.remove("active");
        }
    }
}

const highlightItalic = (bol) => {
    if (bol) {
        if (!(italicDiv.classList.contains("active"))) {
            italicDiv.classList.add("active");
        }
    } else {
        if (italicDiv.classList.contains("active")) {
            italicDiv.classList.remove("active");
        }
    }
}

const highlightUnderline = (bol) => {
    if (bol) {
        if (!(underlineDiv.classList.contains("active"))) {
            underlineDiv.classList.add("active");
        }
    } else {
        if (underlineDiv.classList.contains("active")) {
            underlineDiv.classList.remove("active");
        }
    }
}

const highlightStrikethrough = (bol) => {
    if (bol) {
        if (!(strikethroughDiv.classList.contains("active"))) {
            strikethroughDiv.classList.add("active");
        }
    } else {
        if (strikethroughDiv.classList.contains("active")) {
            strikethroughDiv.classList.remove("active");
        }
    }
}

const highlightOrderedList = (bol) => {
    if (bol) {
        if (!(orderedListDiv.classList.contains("active"))) {
            orderedListDiv.classList.add("active");
        }
    } else {
        if (orderedListDiv.classList.contains("active")) {
            orderedListDiv.classList.remove("active");
        }
    }
}

const highlightUnorderedList = (bol) => {
    if (bol) {
        if (!(unorderedListDiv.classList.contains("active"))) {
            unorderedListDiv.classList.add("active");
        }
    } else {
        if (unorderedListDiv.classList.contains("active")) {
            unorderedListDiv.classList.remove("active");
        }
    }
}

const selectTheProperAlignment = (alignmentName) => {
    alignmentDropDown.value = alignmentName;
}

function handleCursorPositionChange() {

    if (document.queryCommandState("bold")) {
        highlightBold(true);
    } else {
        highlightBold(false);
    }
    
    if (document.queryCommandState("italic")) {
        highlightItalic(true);
    } else {
        highlightItalic(false);
    }

    if (document.queryCommandState("underline")) {
        highlightUnderline(true);
    } else {
        highlightUnderline(false);
    }

    if (document.queryCommandState("strikethrough")) {
        highlightStrikethrough(true);
    } else {
        highlightStrikethrough(false);
    }

    if (document.queryCommandState('justifyRight')) {
        selectTheProperAlignment("justifyRight");
    } else if (document.queryCommandState('justifyCenter')) {
        selectTheProperAlignment("justifyCenter");
    } else {
        selectTheProperAlignment("justifyLeft");
    }

    if (document.queryCommandState('insertUnorderedList')) {
        highlightUnorderedList(true);
    } else {
        highlightUnorderedList(false);
    }

    if (document.queryCommandState('insertOrderedList')) {
        highlightOrderedList(true);
    } else {
        highlightOrderedList(false);
    }
}

const uploadBlog = (blogType) => {
    let blogHeading = document.getElementById("editable-heading");
    let blogContent = document.getElementById("editable-content-area").innerHTML;
    let blogCategory = document.getElementById("editable-category"); 

    if (blogHeading.value == "") {
        showAlert("Please give a valid title for your blog!");
        return;
    } else if (blogContent == '\n            ' || blogContent == "") {
        showAlert("Please have a valid content before uploading");
        return;
    } 
    else if (blogCategory.value == "") {
        showAlert("Please enter a category before uploading!");
        return;
    }
    else if (coverImgPath == null) {
        showAlert("Please select a cover image for your blog");
        let imageUploadPg = document.getElementById("image-upload-pg");
        imageUploadPg.style.zIndex = 150;
        imageUploadPg.style.visibility = "visible";

        uploadedImgActionArea.firstElementChild.style.display = "none";
        // uploadedImgActionArea.lastElementChild.style.visibility = "hidden";
        return;
    }
    imageInfoArray.forEach((ele) => {
        if ( blogContent.includes(ele["imageUrl"]) ) {
            blogContent = blogContent.replace(ele["imageUrl"], ele["imagePath"]);
        }
    });

    //sending blog content to php to be saved in the database
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/upload-blog.php",
        data: {
            blog_heading: blogHeading.value,
            blog_content: blogContent,
            db_name: dbName,
            type: blogType,
            cover_img_path: coverImgPath,
            blog_category: blogCategory.value,
            ff2: ff2,
            user_name: userName,
            email: userEmail
        },
        success: function(response) {
            showAlert(response);
            document.getElementById("editable-content-area").innerHTML = "";
            blogHeading.value = "";
            blogCategory.value = "";
            setTimeout(() => {
                location.replace("dashboard.php");
            }, 1200);
        },
        error: function(response) {
            alert(response);
        }
    })

}

let undoAndRedo = Array.from(document.getElementsByClassName("undo-and-redo"));

undoAndRedo.forEach((btn) => {
    btn.addEventListener("click", () => {
        document.execCommand(btn.id, false, btn.null);
        // btn.value = "#000000";
    });
});