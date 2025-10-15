/**
 * Service API pour communiquer avec le backend ManageVMBack
 */
class ApiService {
    constructor(baseUrl = 'http://localhost:8001') {
        this.baseUrl = baseUrl;
        this.token = localStorage.getItem('jwt_token');
    }

    /**
     * Authentification et obtention du token JWT
     */
    async login(username = 'admin', password = 'admin123') {
        try {
            const response = await fetch(`${this.baseUrl}/api/login_check`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, password })
            });

            if (!response.ok) {
                throw new Error('Authentication failed');
            }

            const data = await response.json();
            this.token = data.token;
            localStorage.setItem('jwt_token', this.token);
            return true;
        } catch (error) {
            console.error('Login error:', error);
            return false;
        }
    }

    /**
     * Vérifier si l'utilisateur est authentifié
     */
    isAuthenticated() {
        return !!this.token;
    }

    /**
     * Obtenir les headers avec le token JWT
     */
    getHeaders() {
        const headers = {
            'Content-Type': 'application/json',
        };

        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }

        return headers;
    }

    /**
     * Effectuer une requête API
     */
    async request(endpoint, options = {}) {
        // Auto-login si pas de token
        if (!this.token) {
            await this.login();
        }

        try {
            const response = await fetch(`${this.baseUrl}${endpoint}`, {
                ...options,
                headers: this.getHeaders()
            });

            // Si token expiré, réessayer avec un nouveau login
            if (response.status === 401) {
                await this.login();
                const retryResponse = await fetch(`${this.baseUrl}${endpoint}`, {
                    ...options,
                    headers: this.getHeaders()
                });
                return await retryResponse.json();
            }

            return await response.json();
        } catch (error) {
            console.error('API request error:', error);
            throw error;
        }
    }

    /**
     * Lister les VMs
     */
    async getVMs(filters = {}) {
        const params = new URLSearchParams(filters);
        return this.request(`/api/v1/vms?${params}`);
    }

    /**
     * Obtenir les détails d'une VM
     */
    async getVM(node, vmid) {
        return this.request(`/api/v1/vms/${node}/${vmid}`);
    }

    /**
     * Démarrer une VM
     */
    async startVM(vmid) {
        return this.request(`/api/v1/vms/${vmid}/start`, {
            method: 'POST'
        });
    }

    /**
     * Arrêter une VM
     */
    async stopVM(vmid, mode = 'acpi') {
        return this.request(`/api/v1/vms/${vmid}/stop`, {
            method: 'POST',
            body: JSON.stringify({ mode })
        });
    }

    /**
     * Lister les snapshots d'une VM
     */
    async getSnapshots(vmid) {
        return this.request(`/api/v1/vms/${vmid}/snapshots`);
    }

    /**
     * Créer un snapshot
     */
    async createSnapshot(vmid, name, description = '') {
        return this.request(`/api/v1/vms/${vmid}/snapshot`, {
            method: 'POST',
            body: JSON.stringify({ name, description })
        });
    }

    /**
     * Restaurer un snapshot
     */
    async rollbackSnapshot(vmid, snapname) {
        return this.request(`/api/v1/vms/${vmid}/snapshot/${snapname}/rollback`, {
            method: 'POST'
        });
    }

    /**
     * Connecter au flux d'événements SSE
     */
    connectEventStream(callbacks = {}) {
        if (!this.token) {
            this.login().then(() => this.connectEventStream(callbacks));
            return;
        }

        const eventSource = new EventSource(
            `${this.baseUrl}/api/v1/events/stream?token=${this.token}`
        );

        // Événements standard
        eventSource.addEventListener('connected', (e) => {
            console.log('Connected to event stream');
            callbacks.onConnected && callbacks.onConnected(JSON.parse(e.data));
        });

        eventSource.addEventListener('heartbeat', (e) => {
            callbacks.onHeartbeat && callbacks.onHeartbeat(JSON.parse(e.data));
        });

        // Événements VM
        ['vm_start', 'vm_stop', 'vm_snapshot', 'task'].forEach(eventType => {
            eventSource.addEventListener(eventType, (e) => {
                const data = JSON.parse(e.data);
                callbacks.onEvent && callbacks.onEvent(eventType, data);
            });
        });

        eventSource.addEventListener('error', (e) => {
            console.error('EventSource error:', e);
            callbacks.onError && callbacks.onError(e);
        });

        return eventSource;
    }
}

// Export pour utilisation
window.ApiService = ApiService;

