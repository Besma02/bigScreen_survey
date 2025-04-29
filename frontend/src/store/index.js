import { createStore } from 'vuex';

export default createStore({
  state: {
    user: null,
    token: localStorage.getItem('auth_token') || '',
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('auth_token', token);  // Sauvegarde du token dans localStorage
    },
    logout(state) {
      state.user = null;
      state.token = '';
      localStorage.removeItem('auth_token');  // Supprime le token du localStorage
    }
  },
  actions: {
    // Action pour la connexion
    async login({ commit }, credentials) {
      try {
        const response = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(credentials),
        });
        const data = await response.json();
        
        if (response.ok && data.access_token) {
          commit('setUser', data.user);
          commit('setToken', data.access_token);
        } else {
          throw new Error(data.message || 'Login failed');
        }
      } catch (error) {
        console.error(error);
        // Vous pouvez ajouter ici une gestion d'erreur ou un message utilisateur
      }
    },

    // Action pour la déconnexion
    async logout({ commit, state }) {
      try {
        const response = await fetch('http://localhost:8000/api/logout', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${state.token}`,
          }
        });
        
        if (response.ok) {
          commit('logout');
        } else {
          throw new Error('Logout failed');
        }
      } catch (error) {
        console.error(error);
        // Vous pouvez ajouter ici une gestion d'erreur ou un message utilisateur
      }
    }
  },
  getters: {
    isAuthenticated(state) {
      return state.token !== '';
    },
    getUser(state) {
      return state.user;
    },
  }
});
