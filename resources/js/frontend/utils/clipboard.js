import { createApp } from 'vue';
import Clipboard from 'clipboard';

function clipboardSuccess() {
  app.config.globalProperties.$message({
    message: 'Copy successfully',
    type: 'success',
    duration: 1500
  });
}

function clipboardError() {
  app.config.globalProperties.$message({
    message: 'Copy failed',
    type: 'error'
  });
}

export default function handleClipboard(text, event) {
  const clipboard = new Clipboard(event.target, {
    text: () => text
  });

  clipboard.on('success', () => {
    clipboardSuccess();
    clipboard.destroy();
  });

  clipboard.on('error', () => {
    clipboardError();
    clipboard.destroy();
  });

  clipboard.onClick(event);
}

const app = createApp({});
