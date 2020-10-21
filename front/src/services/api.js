import axios from 'axios';
import Swal from 'sweetalert2';

export default class Api {
  /**
   * Método construtor
   * @param url
   */
  constructor(url) {
    this.url = url;
  }

  /**
   * Retorna todos os items
   * @returns {Promise<T|{description: *, error: *, status: boolean}|*>}
   */
  async getAll(filter = '') {
    try {
      return await axios.get(`${this.url}?${filter}`).then(res => {
        return {
          status: true,
          data: res.data,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          description: err.response.data.message,
        };
      });
    } catch (error) {
      return error;
    }
  }

  /**
   * Retorna apenas um item da entidade
   * Show
   * @param id
   * @returns {Promise<T|{description: *, error: *, status: boolean}|boolean|{description: null, error: *, status: boolean}>}
   */
  async find(id) {
    if (isNaN(parseInt(id))) {
      notification.showError('Por favor, informe o identificador');
      return;
    }
    try {
      return await axios.get(`${this.url}/${id}`).then(res => {
        return {
          status: res.status,
          data: res.data,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          description: err.response.data.message,
        };
      });
    } catch (error) {
      return {
        status: false,
        error: error,
        description: null,
      };
    }
  }

  /**
   * Salva a entidade pelo formulário
   * @param form
   * @returns {Promise<{data: any, message: *, status: *}|{description: *, error: *, status: boolean}|*>}
   */
  async saveForm(form) {
    try {
      return await form.post(this.url).then(res => {
        notification.showSuccess(res);
        return {
          status: true,
          data: res.response,
          message: res.message,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          message: err.response.data.message,
        };
      });
    } catch (error) {
      return error;
    }
  }

  /**
   * Update entidade pelo form
   * @param form
   * @returns {Promise<{data: any, message: *, status: boolean}|{error: *, message: *, status: boolean}|*>}
   */
  async updateForm(form) {
    try {
      return await form.put(`${this.url}/${form.id}`, form).then(res => {
        notification.showSuccess(res);
        return {
          status: true,
          data: res.response,
          message: res.message,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          message: err.response.data.message,
        };
      });
    } catch (error) {
      return error;
    }
  }

  /**
   * Update de entidade
   * @param id
   * @param data
   * @returns {Promise<{data: any, message: *, status: boolean}|{error: *, message: *, status: boolean}|*>}
   */
  async update(id, data) {
    try {
      return await axios.put(`${this.url}/${id}`, data).then(res => {
        notification.showSuccess(res);
        return {
          status: true,
          data: res.response,
          message: res.message,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          message: err.response.data.message,
        };
      });
    } catch (error) {
      return error;
    }
  }

  /**
   * Salvando entidade
   * @param data
   * @returns {Promise<{data: any, status: boolean}|{description: *, error: *, status: boolean}|*>}
   */
  async save(data) {
    try {
      return await axios.post(this.url, data).then(res => {
        notification.showSuccess(res);
        return {
          status: true,
          data: res.response,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          description: err.response.data.message,
        };
      });
    } catch (error) {
      return error;
    }
  }

  /**
   * Deletando entidade
   * @param id
   * @returns {Promise<T|T>}
   */
  async destroy(id) {
    return await Swal.fire({
      title: 'Deseja excluir?',
      text: 'Cuidado, exclusão permanente',
      type: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim',
    }).then(async result => {
      if (result.value) {
        return await axios.delete(`${this.url}/${id}`).then(res => {
          if (res.data.status === 'success') {
            Swal.fire('Excluído!', '', 'success');
            return {
              status: true,
            };
          } else {
            Swal.fire('Item não excluído', '', 'error');
            return {
              status: false,
            };
          }
        }).catch(err => {
          notification.showErrors(err);
        });
      } else {
        return {
          status: false,
        };
      }
    });
  }

  /**
   * Busca os pré-requisitos da entidade
   * @returns {Promise<T|{description: *, error: *, status: boolean}|{description: null, error: *, status: boolean}>}
   */
  async preRequisite() {
    try {
      return await axios.get(`${this.url}/pre-requisite`).then(res => {
        return {
          status: res.status,
          data: res.data,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          description: err.response.data.message,
        };
      });
    } catch (error) {
      return {
        status: false,
        error: error,
        description: null,
      };
    }
  }

  async reordernar(items) {
    try {
      return await axios.post(`${this.url}/reordenar`, items).then(res => {
        return {
          status: res.status,
          data: res.data,
        };
      }).catch(err => {
        notification.showErrors(err);
        return {
          status: false,
          error: err.message,
          description: err.response.data.message,
        };
      });
    } catch (error) {
      return {
        status: false,
        error: error,
        description: null,
      };
    }
  }


}
