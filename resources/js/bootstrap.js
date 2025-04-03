<<<<<<< Updated upstream
=======
import * as bootstrap from 'bootstrap';


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

>>>>>>> Stashed changes
import axios from 'axios';
window.axios = axios;
window.bootstrap = bootstrap;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
