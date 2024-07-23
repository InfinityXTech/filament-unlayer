// Default URL for the Unlayer editor script
const defaultScriptUrl = 'https://editor.unlayer.com/embed.js?2';

// Array to store callback functions to be executed once the script is loaded
const callbacks = [];
let loaded = false;

/**
 * Checks if a script with the given URL is already injected in the document
 * @param {string} scriptUrl - The URL of the script to check
 * @returns {boolean} - True if the script is already injected, otherwise false
 */
const isScriptInjected = (scriptUrl) => {
    const scripts = document.querySelectorAll('script');
    let injected = false;

    scripts.forEach((script) => {
        if (script.src.includes(scriptUrl)) {
            injected = true;
        }
    });

    return injected;
};

/**
 * Adds a callback function to the callbacks array
 * @param {function} callback - The callback function to add
 */
const addCallback = (callback) => {
    callbacks.push(callback);
};

/**
 * Executes all stored callback functions if the script is loaded
 */
const runCallbacks = () => {
    if (loaded) {
        let callback;

        while ((callback = callbacks.shift())) {
            callback();
        }
    }
};

/**
 * Loads the Unlayer script and executes the callback once the script is loaded
 * @param {function} callback - The callback function to execute
 * @param {string} [scriptUrl=defaultScriptUrl] - The URL of the script to load
 */
export const loadScript = (
    callback,
    scriptUrl = defaultScriptUrl
) => {
    addCallback(callback);

    if (!isScriptInjected(scriptUrl)) {
        const embedScript = document.createElement('script');
        embedScript.setAttribute('src', scriptUrl);
        embedScript.onload = () => {
            loaded = true;
            runCallbacks();
        };
        document.head.appendChild(embedScript);
    } else {
        runCallbacks();
    }
};

/**
 * Initializes the Unlayer editor with the given options
 * @param {object} options - Options for initializing Unlayer
 * @param {object} options.state - The initial state of the editor
 * @param {string} options.displayMode - The display mode of the editor
 * @param {string} options.id - The ID of the HTML element to attach the editor to
 * @param {string} options.uploadUrl - The URL to upload images
 * @returns {object} - The initialization object with state and init function
 */
export default function initUnlayer({
    state,
    displayMode,
    id,
    uploadUrl,
}) {
    return {
        state,

        init() {
            const self = this; // Capture the current context
            loadScript(() => {
                unlayer.init({
                    id: id,
                    displayMode: displayMode
                });

                unlayer.registerCallback('image', (file, done) => {
                    uploadImage(file.attachments[0], uploadUrl)
                        .then(url => done({ progress: 100, url }))
                        .catch(error => console.error('Image upload failed:', error));
                });

                let internalUpdate = false;
                let boot = true;

                self.$watch('state', value => {
                    if (!internalUpdate) {
                        let design = value.design !== undefined ? value.design : value;
                        unlayer.loadDesign(JSON.parse(JSON.stringify(design)));
                        boot = false;
                        unlayer.exportHtml(data => {
                            internalUpdate = true;
                            if (self.state) {
                                self.state = { html: data.html, design: JSON.parse(JSON.stringify(data.design)) };
                            }
                            let el = document.getElementById(id);
                            if (el) {
                                el.dirty = true;
                            }
                            
                            boot = false;
                        });
                    }
                    internalUpdate = false;
                });

                unlayer.addEventListener('design:updated', () => {
                    unlayer.exportHtml(data => {
                        if (!boot) {
                            internalUpdate = true; // Set flag before updating state
                        }
                        if (self.state) {
                            self.state = boot ? { html: self.state.html, design: JSON.parse(JSON.stringify(self.state.design)) }
                                              : { html: data.html, design: JSON.parse(JSON.stringify(data.design)) };
                        }
                        let el = document.getElementById(id);
                        if (el) {
                            el.dirty = true;
                        }
                        
                        boot = false;
                    });
                });
            });
        }
    }
}

/**
 * Uploads an image file to the specified URL
 * @param {File} file - The image file to upload
 * @param {string} uploadUrl - The URL to upload the image to
 * @returns {Promise<string>} - A promise that resolves with the URL of the uploaded image
 */
function uploadImage(file, uploadUrl) {
    let data = new FormData();
    data.append('file', file);

    return fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: data
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Network response was not ok.');
    })
    .then(data => data.file.url);
}

// Initialize Unlayer editor when the DOM content is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    if (typeof Alpine !== 'undefined') {
        Alpine.data('initUnlayer', initUnlayer);
    }
});
