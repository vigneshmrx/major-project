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
                    <abbr title="Undo (Ctrl + Z)">
                        <img src="./icons/icons8-undo-48_grey.png" alt="">
                    </abbr>
                </div>
                <div onclick="redo();">
                    <abbr title="Redo (Ctrl + Y)">
                        <img src="./icons/icons8-redo-48-grey.png" alt="">
                    </abbr>
                </div>

                <div class="seperator">
                    <img src="./icons/icons8-seperator-48-grey.png" alt="">
                </div>

                <div>
                    <!-- <img src="./icons/icons8-font-size-48-grey.png" alt=""> -->
                    <select name="" id="font-change-drop-down">
                        <!-- <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                        <option value="Extralarge">Extralarge</option> -->
                        <option value="12px">12px</option>
                        <option value="16px" selected>16px</option>
                        <option value="20px">20px</option>
                        <option value="24px">24px</option>
                        <option value="28px">28px</option>
                        <option value="32px">32px</option>
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

                <div onclick="" id="bold-div"> <!--  -->
                    <abbr title="Bold (Ctrl + B)">
                        <img src="./icons/icons8-bold-48-grey.png" alt="">
                    </abbr>
                </div>
                <div onclick="" id="italic-div"> <!-- formatTextFun('italic');  toggleFormatting('italic');-->
                    <abbr title="Italic (Ctrl + I)">
                        <img src="./icons/icons8-italic-48-grey.png" alt="">
                    </abbr>
                </div>
                <div onclick="" id="underline-div"> <!-- formatTextFun('underline'); -->
                    <abbr title="Underline (Ctrl + U)">
                        <img src="./icons/icons8-underline-48-grey.png" alt="">
                    </abbr>
                </div>
                <div onclick="" id="strikethrough-div">
                    <abbr title="Strikethrough">
                        <img src="./icons/icons8-strikethrough-50-grey.png" alt="">
                    </abbr>
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
                    <abbr title="Emoji (Win + .)">
                        <img src="./icons/icons8-smiley-48-grey.png" alt="">
                    </abbr>
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
    <script src="./js/create-blog.js"></script>
    <script>

        let lastSelectedRange = null;

function boldText() {
  const selection = window.getSelection();

  if (selection.rangeCount > 0) {
    const range = selection.getRangeAt(0);

    // Check if the selection is already bold
    const isBold = range.commonAncestorContainer.parentElement.tagName === 'B';

    // Create a <b> or <span> element based on the current state
    const containerElement = isBold ? document.createElement('span') : document.createElement('b');
    containerElement.appendChild(range.extractContents());
    range.insertNode(containerElement);

    // Remember the last selected range
    lastSelectedRange = range;

    // Clear the selection
    selection.removeAllRanges();
  } else {
    applyBoldToFutureContent();
  }
}


        



 
    </script>
</body>
</html>