/**
*/
import { loadBranches } from './functions/loadBranches.js';

export const appBranches = () => {
    document.getElementById('warehouse').addEventListener('change', function() {
        loadBranches(this.value);
    });
}
