import store from '../store';
import {mapGetters} from 'vuex';
// import {app} from '~/app'

mapGetters({
  auth: 'user',
});

export default {
  /**
   * Retorna a empresa do usuário logado
   */
  getNameEmpresa() {
    let empresa = this.getUserParam('empresa');
    return 'Empresa taaaal';
    return empresa.nome;
  },

  /**
   * Retorna parâmetros do usuário logado
   * @param name
   */
  getUserParam(name) {
    let user = store.getters['auth/user'];
    if (user && user.hasOwnProperty(name)) {
      return user[name];
    }
    return '';
  },

  /**
   * Retorna usuário logado
   */
  getAuthUser() {
    return store.getters['auth/user'];
  },


  /**
   * Retorna nome do usuário logado
   */
  getUserName() {
    return this.getUserParam('name');
  },

  /**
   * Retorna o id do usuário logado
   */
  getUserId() {
    return this.getUserParam('id');
  },


  /**
   * Transforma a rota em permissão
   * ex: /configuration/perfil | configuration-perfil
   * @param route
   */
  routeToPermission(route) {
    String.prototype.replaceAll = function(match, replace) {
      return this.split(match).join(replace);
    };
    route = route.replaceAll('/', '-');
    if (route[0] == '-') {
      route = route.replace(route.substring(0, 1), '');
    }
    return route;
  },

  /**
   * Mostra apenas um erro
   * @param error
   */
  showError(msg) {
    app.$toast.error(msg);
  },

  /**
   * Mostra apenas uma mensagem de sucesso
   * @param msg
   */
  showSuccessMsg(msg) {
    app.$toast.success(msg);
  },

  /**
   * Mostra warnings
   * @param msg
   */
  showWarning(msg) {
    app.$toast.warning(msg);
  },

  showInfoMsg(msg) {
    app.$toast.info(msg);
  },

  /**
   * Mostra mensagem de sucesso
   * @param success
   */
  showSuccess(success) {
    if (success.hasOwnProperty('message')) {
      if (success.status == 'success') {
        this.showSuccessMsg(success.message);
        return;
      }
    }

    if (success.data.hasOwnProperty('message')) {
      if (success.data.status == 'success') {
        this.showSuccessMsg(success.data.message);
        return;
      }
    }
  },

  /**
   * Trata o array de erros do serve
   * @param arrayErros
   */
  showErrors(error) {
    /**
     * Se for apenas um erro, mostra o único
     */
    if (error.hasOwnProperty('data') && error.data.hasOwnProperty('error')) {
      if (error.data.error.hasOwnProperty('message')) {
        this.showError(error.data.error.message);
      }
      return;
    }

    /**
     * Se tiver paenas a mensagem, então motra a mensagem!
     */
    if (error.hasOwnProperty('message')) {
      if (error.status == 'error') {
        this.showError(error.message);
      }
      return;
    }

    /**
     * Se for vários errors, então varre o array e mostra todos
     */
    if (error.hasOwnProperty('data') && error.data.hasOwnProperty('errors')) {
      if (error.data.errors.hasOwnProperty('message')) {
        error.data.errors.message.map(error => {
          this.showError(error);
        });
      }
      return;
    }

    /**
     * Se for vários errors, então varre o array e mostra todos
     */
    if (error.hasOwnProperty('errors')) {
      if (error.errors.hasOwnProperty('message')) {
        error.errors.message.map(error => {
          this.showError(error);
        });
      }
      return;
    }

    /**
     * Se não existir a propriedade error, então verifica se existe a propriedade message
     * Questão de autorização do  usuário
     */
    if (error.hasOwnProperty('data') && error.data.hasOwnProperty('message')) {
      this.showError(error.data.message);
    }
  },

  /**
   * Usuário está autenticado?
   * @returns {getters.getAuthStatus}
   */
  isAuth() {
    return store.getters.getAuthStatus;
  },

  /**
   * Remover o token do usuario no backend
   */
  logout() {
    return axios.post('/api/auth/logout');
  },

  /**
   * Função que retornar a logotipo do sistema.
   */
  getAvatarLogo() {
    return '../assets/logo.jpeg';
  },

  // to get date in desired format
  formatDate(date) {
    if (!date) return;

    return moment(date).format(this.getConfig('date_format'));
  },


};
