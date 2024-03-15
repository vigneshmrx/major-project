//undo and redo code begins here
const editableDiv = document.getElementById('editable-content-area');
const undoStack = [];
let currentStateIndex = -1;

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

const imgUploadFun = (event) => {
    let img = document.createElement("img");
    // img.src = URL.createObjectURL(uploadImgBtn.files[0]);
    selectedFile = event.target.files[0];
    imageUrl = URL.createObjectURL(selectedFile);
    img.src = imageUrl;

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

        let img = document.createElement("img");
        img.src = imageUrl;

        imageUploadPg.style.zIndex = -150;
        imageUploadPg.style.visibility = "hidden";

        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        range.insertNode(img);

        range.setStartAfter(img);
        range.collapse(true);

        selection.removeAllRanges();
        selection.addRange(range);          
        // document.execCommand('insertImage', false, imageUrl);
    } else {
        showAlert("Please select an image before uploading!");
    }
}