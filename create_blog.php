<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        <?php include './css/common-styles.css'; ?>
        <?php include './css/create-blog.css'; ?>
    </style>
</head>
<body>
    <header>
        <div id="logo">
            ProDo
        </div>
        <div class="greeting">
            Hello, Eren
        </div>
    </header>
    
    <div id="write-blog-area-with-options">
        <div id="all-the-options-for-user">
            <div id="text-formatting-options-area">
                <div onclick="undo();">
                    <img src="./icons/icons8-undo-48_grey.png" alt="">
                </div>
                <div onclick="redo();">
                    <img src="./icons/icons8-redo-48-grey.png" alt="">
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div>
                    <!-- <img src="./icons/icons8-font-size-48-grey.png" alt=""> -->
                    <select name="" id="">
                        <option value="12px">12px</option>
                        <option value="24px">24px</option>
                        <option value="36px">36px</option>
                        <option value="48px">48px</option>
                    </select>
                </div>
                <div>
                    <select name="" id="">
                        <option value="Heading">Heading</option>
                        <option value="Subheading">Subheading</option>
                        <option value="Paragraph">Paragraph</option>
                    </select>
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div onclick="toggleFormat('bold');">
                    <img src="./icons/icons8-bold-48-grey.png" alt="">
                </div>
                <div onclick="toggleFormat('italic');">
                    <img src="./icons/icons8-italic-48-grey.png" alt="">
                </div>
                <div onclick="toggleFormat('underline');">
                    <img src="./icons/icons8-underline-48-grey.png" alt="">
                </div>
                <div>
                    <img src="./icons/icons8-text-color-grey.png" alt="">
                </div>
                <div>
                    <img src="./icons/icons8-text-bg-color-60-grey.png" alt="">
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div>
                    <img src="./icons/icons8-image-48-grey.png" alt="">
                </div>
                <div>
                    <img src="./icons/icons8-smiley-48-grey.png" alt="">
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div>
                    <select name="" id="">
                        <option value="Left Align">Left Align</option>
                        <option value="Center Align">Center Align</option>
                        <option value="Right Align">Right Align</option>
                    </select>
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div>
                    <img src="./icons/icons8-quote-50-grey.png" alt="">
                </div>
                <div onclick="toggleList('unordered');">
                    <img src="./icons/icons8-bullet-list-60-grey.png" alt="">
                </div>
                <div onclick="toggleList('ordered');">
                    <img src="./icons/icons8-numbered-list-60-grey.png" alt="">
                </div>
                <div>
                    <img src="./icons/icons8-minus-48-grey.png" alt="">
                </div>
            </div>
            <div id="blog-action-btn-area"></div>
        </div>

        <div id="editable-heading-area">
            <input type="text" placeholder="Your Heading Here">
            <!-- <textarea name="" id="" placeholder="Your Heading Here"></textarea> -->
        </div>
        <div id="editable-content-area" contenteditable="true">
        </div>
    </div>

    <script>
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

        function toggleFormat(format) {
    const selection = window.getSelection();

    if (selection.rangeCount > 0) {
      const range = selection.getRangeAt(0);
      const span = document.createElement('span');
      span.classList.add(format);

      const isAlreadyFormatted = range.commonAncestorContainer.parentElement.classList.contains(format);

      if (isAlreadyFormatted) {
        const parent = range.commonAncestorContainer.parentElement;
        parent.replaceWith(...parent.childNodes);
      } else {
        span.appendChild(range.extractContents());
        range.insertNode(span);
      }
    }
  }

  function toggleList(type) {
    const selection = window.getSelection();

    if (selection.rangeCount > 0) {
      const range = selection.getRangeAt(0);
      const listElement = document.createElement(type === 'unordered' ? 'ul' : 'ol');
      listElement.classList.add(type === 'unordered' ? 'unordered-list' : 'ordered-list');

      const isAlreadyList = range.commonAncestorContainer.parentElement.tagName.toLowerCase() === type === 'unordered' ? 'ul' : 'ol';

      if (isAlreadyList) {
        const parent = range.commonAncestorContainer.parentElement;
        parent.replaceWith(...parent.childNodes);
      } else {
        listElement.appendChild(range.extractContents());
        range.insertNode(listElement);
      }
    }
  }

  function toggleHorizontalRule() {
    const selection = window.getSelection();

    if (selection.rangeCount > 0) {
      const range = selection.getRangeAt(0);
      const hr = document.createElement('hr');

      const isAlreadyHR = range.commonAncestorContainer.parentElement.tagName.toLowerCase() === 'hr';

      if (isAlreadyHR) {
        const hrElement = range.commonAncestorContainer.parentElement;
        hrElement.parentNode.removeChild(hrElement);
      } else {
        range.deleteContents();
        range.insertNode(hr);
      }
    }
  }
    </script>
</body>
</html>