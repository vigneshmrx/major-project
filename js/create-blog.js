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

// function formatTextFun(formatType) {
//     const nodeObj = {"bold" : "b", "italic" : "i" }
//     // , "underline" : "span", "strikethrough" : "span"};

//     const otherObj = {"strikethrough" : "strike-text", "underline" : "underline-text"};

//     const spanClassObj = {"bold" : "un-bold-text", "italic" : "un-italicize-text", "underline" : "un-underline-text", "strikethrough" : "un-strike-text"};

//     if (selection.rangeCount > 0) {
//         const range = selection.getRangeAt(0);

//         // const isAlreadyFormatType = range.commonAncestorContainer.parentElement.tagName === nodeObj[formatType].toUpperCase();

//         let isAlreadyFormatType;

//         let containerElement;

//         // if (isAlreadyFormatType) {
//         //     containerElement = document.createElement("span");
//         //     containerElement.className = spanClassObj[formatType];

//         // } else {

//             if (formatType == "strikethrough" || formatType == "underline") {
//                 isAlreadyFormatType = range.commonAncestorContainer.parentElement.className === "strike-text" || range.commonAncestorContainer.parentElement.className === "underline-text";

//                 containerElement = document.createElement("span");

//                 if (isAlreadyFormatType) {
//                     containerElement.className = spanClassObj[formatType];
//                 } else {
//                     containerElement.className = otherObj[formatType];
//                 }

//                 // containerElement = document.createElement("span");
//                 // containerElement.className = otherObj[formatType];

//             } else {

//                 isAlreadyFormatType = range.commonAncestorContainer.parentElement.tagName === nodeObj[formatType].toUpperCase();

//                 if (isAlreadyFormatType) {
//                     containerElement = document.createElement("span");
//                     containerElement.className = spanClassObj[formatType];
//                 } else {
//                     containerElement = document.createElement(nodeObj[formatType]);
//                 }

//                 // containerElement = createElement(nodeObj[formatType]);

//             }
//         // }
        
//         // const containerElement = isAlreadyFormatType ? document.createElement('span') : document.createElement(nodeObj[formatType]);

//         // if (containerElement.tagName == "SPAN") {
//         //     containerElement.className = spanClassObj[formatType];
//         // }

//         containerElement.appendChild(range.extractContents());
//         range.insertNode(containerElement);
//     }

//     selection.removeAllRanges();
// }

// function toggleFormatting(style) {
//     const selection = window.getSelection();
//     if (!selection.rangeCount) return;
  
//     const range = selection.getRangeAt(0); // Get existing range
  
//     const formattedElements = [];
  
//     // Wrap text nodes in formatted spans (if selection exists)
//     if (selection.toString()) {
//       Array.from(range.extractContents().childNodes).forEach(node => {
//         if (node.nodeType === Node.TEXT_NODE) {
//           const element = document.createElement("span");
//           element.style[style] = selection.toString().includes(style) ? "none" : "inherit";
//           element.appendChild(node.cloneNode(true));
//           formattedElements.push(element);
//         } else {
//           formattedElements.push(node); // Add non-text nodes as-is
//         }
//       });
  
//       range.insertNode(document.createDocumentFragment(...formattedElements));
//     } else {
//       // Handle no selection (create a new formatted span for bold on first keypress)
//       if (style === "bold" && !selection.toString()) {
//         const element = document.createElement("span");
//         element.style.fontWeight = "bold";
//         range.insertNode(element);
//       }
//     }
// }

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