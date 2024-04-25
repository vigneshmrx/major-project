import { EmojiButton } from '../node_modules/@joeattardi/emoji-button';

const picker = new EmojiButton();
const trigger = document.querySelector('.trigger');

picker.on('emoji', selection => {
  trigger.innerHTML = selection.emoji;
});

trigger.addEventListener('click', () => picker.togglePicker(trigger));