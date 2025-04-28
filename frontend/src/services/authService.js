import axios from 'axios';

export const login = async (credentials) => {
  const response = await axios.post('/api/login', credentials);
  return response.data;
};

export const logout = async () => {
  await axios.post('/api/logout');
};

export const register = async (userData) => {
  const response = await axios.post('/api/register', userData);
  return response.data;
};
