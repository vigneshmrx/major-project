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


const selection = window.getSelection();

function formatTextFun(formatType) {
    const nodeObj = {"bold" : "b", "italic" : "i", "underline" : "u", }

    const spanClassObj = {"bold" : "un-bold-text", "italic" : "un-italicize-text", "underline" : "un-underline-text"}


    // const selection = window.getSelection();

    if (selection.rangeCount > 0) {
        const range = selection.getRangeAt(0);

        // const isItalic = range.commonAncestorContainer.parentElement.tagName === "I";

        const isAlreadyFormatType = range.commonAncestorContainer.parentElement.tagName === nodeObj[formatType].toUpperCase();

        // const containerElement = isItalic ? document.createElement('span') : document.createElement('i');
        
        const containerElement = isAlreadyFormatType ? document.createElement('span') : document.createElement(nodeObj[formatType]);

        // if (containerElement.tagName == "SPAN") {
        //     containerElement.className = "unitalicize-text";
        // }

        if (containerElement.tagName == "SPAN") {
            containerElement.className = spanClassObj[formatType];
        }

        containerElement.appendChild(range.extractContents());
        range.insertNode(containerElement);
    }

    selection.removeAllRanges();
}


editableDiv.addEventListener("input", () => {

});
