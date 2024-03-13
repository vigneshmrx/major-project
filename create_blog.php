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

    <div id="color-pallet-pg">
        <div id="color-pallet-box">
            <div id="color-pallet-heading-area">
                <div class="color-pallet-heading">CHOOSE COLOR</div>
                <div class="close-pop-up-icon-area" onclick="removePopUp(this, [2, 3]);">
                    <img src="./icons/icons8-close-32.png" alt="">
                </div>
            </div>

            <hr class="popup-box-hr" style="margin: auto; margin-bottom: 10px;">

            <div class="choose-colors">
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(102, 0, 0)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(120, 63, 4)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(127, 96, 0)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(39, 78, 19)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(12, 52, 61)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(7, 55, 99)" onclick="setThisColorTwo(this);"></div>
                    <div class="individual-color-box" id="rgb(32, 18, 77)" onclick="setThisColor(this);"></div>
                    <div class="individual-color-box" id="rgb(76, 17, 48)" onclick="setThisColor(this);"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(153, 0, 0)"></div>
                    <div class="individual-color-box" id="rgb(180, 95, 6)"></div>
                    <div class="individual-color-box" id="rgb(191, 144, 0)"></div>
                    <div class="individual-color-box" id="rgb(56, 118, 29)"></div>
                    <div class="individual-color-box" id="rgb(19, 79, 92)"></div>
                    <div class="individual-color-box" id="rgb(11, 83, 148)"></div>
                    <div class="individual-color-box" id="rgb(53, 28, 117)"></div>
                    <div class="individual-color-box" id="rgb(116, 27, 71)"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(204, 0, 0)"></div>
                    <div class="individual-color-box" id="rgb(230, 145, 56)"></div>
                    <div class="individual-color-box" id="rgb(241, 194, 50)"></div>
                    <div class="individual-color-box" id="rgb(106, 168, 79)"></div>
                    <div class="individual-color-box" id="rgb(69, 129, 142)"></div>
                    <div class="individual-color-box" id="rgb(61, 133, 198)"></div>
                    <div class="individual-color-box" id="rgb(103, 78, 167)"></div>
                    <div class="individual-color-box" id="rgb(166, 77, 121)"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(224, 102, 102)"></div>
                    <div class="individual-color-box" id="rgb(246, 178, 107)"></div>
                    <div class="individual-color-box" id="rgb(255, 217, 102)"></div>
                    <div class="individual-color-box" id="rgb(147, 196, 125)"></div>
                    <div class="individual-color-box" id="rgb(118, 165, 175)"></div>
                    <div class="individual-color-box" id="rgb(111, 168, 220)"></div>
                    <div class="individual-color-box" id="rgb(142, 124, 195)"></div>
                    <div class="individual-color-box" id="rgb(194, 123, 160)"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(234, 153, 153)"></div>
                    <div class="individual-color-box" id="rgb(249, 203, 156)"></div>
                    <div class="individual-color-box" id="rgb(255, 229, 153)"></div>
                    <div class="individual-color-box" id="rgb(182, 215, 168)"></div>
                    <div class="individual-color-box" id="rgb(162, 196, 201)"></div>
                    <div class="individual-color-box" id="rgb(159, 197, 232)"></div>
                    <div class="individual-color-box" id="rgb(180, 167, 214)"></div>
                    <div class="individual-color-box" id="rgb(213, 166, 189)"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(244, 204, 204)"></div>
                    <div class="individual-color-box" id="rgb(252, 229, 205)"></div>
                    <div class="individual-color-box" id="rgb(255, 242, 204)"></div>
                    <div class="individual-color-box" id="rgb(217, 234, 211)"></div>
                    <div class="individual-color-box" id="rgb(208, 224, 227)"></div>
                    <div class="individual-color-box" id="rgb(207, 226, 243)"></div>
                    <div class="individual-color-box" id="rgb(217, 210, 233)"></div>
                    <div class="individual-color-box" id="rgb(234, 209, 220)"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="red"></div>
                    <div class="individual-color-box" id="orange"></div>
                    <div class="individual-color-box" id="yellow"></div>
                    <div class="individual-color-box" id="lime"></div>
                    <div class="individual-color-box" id="aqua"></div>
                    <div class="individual-color-box" id="blue"></div>
                    <div class="individual-color-box" id="purple"></div>
                    <div class="individual-color-box" id="fuchsia"></div>
                </div>
                <div class="choose-colors-row">
                    <div class="individual-color-box" id="rgb(0, 0, 0)"></div>
                    <div class="individual-color-box" id="rgb(68, 68, 68)"></div>
                    <div class="individual-color-box" id="rgb(102, 102, 102)"></div>
                    <div class="individual-color-box" id="rgb(153, 153, 153)"></div>
                    <div class="individual-color-box" id="rgb(204, 204, 204)"></div>
                    <div class="individual-color-box" id="rgb(238, 238, 238)"></div>
                    <div class="individual-color-box" id="rgb(243, 24, 243)"></div>
                    <div class="individual-color-box" id="rgb(255, 255, 255)"></div>
                </div>
            </div>
        </div>
    </div>

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
                <!-- <div>
                    <select name="" id="">
                        <option value="Heading">Heading</option>
                        <option value="Subheading">Subheading</option>
                        <option value="Paragraph">Paragraph</option>
                    </select>
                </div> -->

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
                <div id="fore-color-div" onclick="showColorPanel('forecolor');">
                    <abbr title="Text Color">
                        <img src="./icons/icons8-text-color-grey.png" alt="">
                    </abbr>
                </div>
                <div onclick="showColorPanel('backcolor');">
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
            <div id="blog-action-btn-area">
                <div class="archive-btn">
                    <input type="button" value="Archive">
                </div>
                <div class="upload-btn">
                    <input type="button" value="Upload">
                </div>
            </div>
        </div>

        <div id="editable-heading-area">
            <input type="text" placeholder="Your Heading Here">
            <!-- <textarea name="" id="" placeholder="Your Heading Here"></textarea> -->
        </div>
        <div id="editable-content-area" contenteditable="true">
        </div>
    </div>
    <script src="./js/common-script.js"></script>
    <script src="./js/create-blog.js"></script>
    <script>
        let individualColorBoxes = Array.from(document.getElementsByClassName("individual-color-box"));

        individualColorBoxes.forEach((box) => {
            box.style.background = box.id;
        })
    </script>
</body>
</html>