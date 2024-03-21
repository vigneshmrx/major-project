const dbName = localStorage.getItem("dbName");

//undo and redo code begins here
const editableDiv = document.getElementById('editable-content-area');
const undoStack = [];
let currentStateIndex = -1;
// let imagesUrlArray = [];
// let imagesPathArray = [];
let imageInfoArray = [];

function saveState() {
    const content = editableDiv.innerHTML;
    if (currentStateIndex < undoStack.length - 1) {
    // Clear redo stack if changes were made after undo
        undoStack.splice(currentStateIndex + 1);
    }
    undoStack.push(content);
    currentStateIndex = undoStack.length - 1;
}

function undo() {
    if (currentStateIndex > 0) {
        currentStateIndex--;
        editableDiv.innerHTML = undoStack[currentStateIndex];
    }
}

function redo() {
    if (currentStateIndex < undoStack.length - 1) {
        currentStateIndex++;
        editableDiv.innerHTML = undoStack[currentStateIndex];
    }
}

editableDiv.addEventListener('beforeinput', saveState);
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
  
    // Approach 1: Wrap selection in span with increased font-size
    // const newFontSize = parseInt(getComputedStyle(editableDiv).fontSize, 10) + 2; // Increase by 2px
  
    const span = document.createElement("span");
    span.style.fontSize = newFontSize
    range.surroundContents(span);

    selection.collapseToEnd(); // Collapse selection to the end for further editing
}

fontChange.addEventListener("change", (e) => {
    increaseFontSize(e.target.value);
})

let foreColor = backColor = false;
let colorPalletPg = document.getElementById("color-pallet-pg");

const showColorPanel = (colorType) => {
    popUpBgFun();

    console.log("Show color panel called"); 

    colorPalletPg.style.zIndex = 150;
    colorPalletPg.style.visibility = "visible";

    if (colorType == "forecolor") {
        foreColor = !foreColor;
    } else {
        backColor = !backColor;
    }
}

const setThisColor = (objRef) => {
    let color = objRef.id;

    // colorPalletPg.style.zIndex = -150;
    // colorPalletPg.style.visibility = "hidden";

    // popUpBgFun();

    console.log(color);

    let selection = window.getSelection();

    // if (!selection.rangeCount) return;

    if (selection.rangeCount > 0) {
        let range = selection.getRangeAt(0);

        let span = document.createElement("span");

        if (foreColor) {
            // document.execCommand("foreColor", false, color);
            span.style.color = color;
            console.log("Fore color is set");
            foreColor = !foreColor;
        } else {
            // document.execCommand("backColor", false, "#783f04");
            span.style.background = color;
            console.log("Back color is set");
            backColor = !backColor;
        }

        //some error here. Rectify it. 

        let selectedContent = range.extractContents().textContent.toString();

        // const serializer = new XMLSerializer();
        // let selectedContent = serializer.serializeToString(range.extractContents());

        console.log(typeof(selectedContent));
        console.log(selectedContent);   

        // span.appendChild(range.extractContents());
        // span.appendChild(selectedContent);
        span.innerText = selectedContent;

        console.log(span);

        // range.surroundContents(span);

        
        // range.deleteContents();
        range.insertNode(span);
        selection.collapseToEnd();
    }

    editableDiv.focus();
}

//for uploading image
const imgUploadFun = (event) => {
    let img = document.createElement("img");
    // img.src = URL.createObjectURL(uploadImgBtn.files[0]);
    selectedFile = event.target.files[0];
    console.log(selectedFile);
    imageUrl = URL.createObjectURL(selectedFile);
    img.src = imageUrl;

    imagePath = "../major-project/images/user-images/" + dbName + "/" + selectedFile["name"];


    //to get all the uploaded images in the blog
    // imagesUrlArray.push(imageUrl);
    // imagesPathArray.push(imagePath);

    let imageInfoObj = {"imageUrl" : imageUrl, "imagePath" : imagePath};
    imageInfoArray.push(imageInfoObj);

    uploadedImgAreaOldContent = uploadedImageArea.innerHTML;

    uploadedImageArea.innerHTML = "";
    // uploadedImageArea.innerHTML = img;
    uploadedImageArea.appendChild(img);
}

const deleteSelectedImg = () => {
    if (uploadedImageArea.firstChild.tagName == "IMG") {
        uploadedImageArea.innerHTML = "";
        uploadedImageArea.innerHTML = uploadedImgAreaOldContent;
        uploadImgBtn.value = "";
    }
}

const insertImageIntoPage = () => {
    if (imageUrl !== null && imageUrl !== undefined) {
        let imageUploadPg = document.getElementById("image-upload-pg");

        let div = document.createElement("div");
        div.style = "width: 100%; display: grid; place-items: center;"

        let img = document.createElement("img");
        img.src = imageUrl;
        img.style = "width: 60%;"

        div.appendChild(img);

        imageUploadPg.style.zIndex = -150;
        imageUploadPg.style.visibility = "hidden";

        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        // range.insertNode(img);
        range.insertNode(div);
        
        // range.setStartAfter(img);
        range.setStartAfter(div);
        range.collapse(true);

        selection.removeAllRanges();
        selection.addRange(range);          
        // document.execCommand('insertImage', false, imageUrl);\

        uploadedImageArea.innerHTML = uploadedImgAreaOldContent;

        //uploading image to user's folder

        var formData = new FormData();
        formData.append("file", selectedFile);
        formData.append("folder_name", dbName);
        // console.log(formData)

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../major-project/php-ajax/upload_img.php', true);
        // xhr.onload = function() {
        //     if (xhr.status === 200) {
        //         console.log('Response:', xhr.responseText);
        //     } else {
        //         console.error('Request failed:', xhr.status);
        //     }
        // };
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
    // console.log(e.target.value);
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
//   const selection = window.getSelection();
//   const cursorPosition = selection.focusOffset;

//   if (cursorPosition !== previousCursorPosition) {
//     console.log('Cursor position changed:', cursorPosition);
//     previousCursorPosition = cursorPosition;
//   }

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
    let blogContent = editableDiv.innerHTML;
    // console.log(editableDiv);    

    if (blogHeading.value == "") {
        showAlert("Please give a valid title for your blog!");
        return;
    } else if (blogContent == '\n        ' || blogContent == "") {
        showAlert("Please have a valid content before uploading");
        return;
    }
    
    // console.log(imageInfoArray);
    imageInfoArray.forEach((ele) => {
        if ( blogContent.includes(ele["imageUrl"]) ) {
            console.log("Yes it includes");
            blogContent = blogContent.replace(ele["imageUrl"], ele["imagePath"]);
        }
    });

    console.log(blogContent);

    //sending blog content to php to be saved in the database
    $.ajax({
        type: "POST",
        url: "../major-project/php-ajax/upload-blog.php",
        data: {
            blog_heading: blogHeading,
            blog_content: blogContent,
            db_name: dbName,
            type: blogType
        }
    })
}


//special quote box

// function insertSpecialQuoteBox() {
//     const div = document.createElement('blockquote');
//     // div.textContent = 'New Div';

//     div.className = "special-quote-box";

//     const selection = window.getSelection();
//     const range = selection.getRangeAt(0);

//     range.deleteContents();
//     range.insertNode(div);

//     editableDiv.focus();
// }

// editableDiv.addEventListener('keydown', (event) => {
//     var selection = window.getSelection();
//     var range = selection.getRangeAt(0);
  
//     if (event.key === 'Enter' && isCursorInBlockquote(range)) {
//       event.preventDefault(); // Prevent default Enter behavior
  
//       // Create a new div element
//       var div = document.createElement('div');
  
//       // Insert the div after the blockquote containing the cursor
//       var blockquote = getBlockquoteContainingCursor(range);
//       if (blockquote) {
//         blockquote.parentNode.insertBefore(div, blockquote.nextSibling);
  
//         // Move the cursor to the newly inserted div
//         var newRange = document.createRange();
//         newRange.setStartAfter(div);
//         newRange.collapse(true);
//         selection.removeAllRanges();
//         selection.addRange(newRange);
//       }
//     }
// });
  
//   function isCursorInBlockquote(range) {
//     var blockquote = getBlockquoteContainingCursor(range);
//     return blockquote !== null;
//   }
  
//   function getBlockquoteContainingCursor(range) {
//     var blockquotes = document.querySelectorAll('blockquote');
//     for (var i = 0; i < blockquotes.length; i++) {
//       var blockquote = blockquotes[i];
//       if (blockquote.contains(range.startContainer) || blockquote.contains(range.endContainer)) {
//         return blockquote;
//       }
//     }
//     return null;
//   }