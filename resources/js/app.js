import './bootstrap';

import Alpine from 'alpinejs';

// === POCZĄTEK DODANEGO KODU ===
import confetti from 'canvas-confetti';
window.confetti = confetti;
// === KONIEC DODANEGO KODU ===

window.Alpine = Alpine;

Alpine.start();
