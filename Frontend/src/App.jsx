import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Homepage from './views/homepage.jsx';
import Login from './views/login.jsx';

function App() {
  return (
    <Routes> 
      <Route path="/" element={<Homepage />} /> 
      <Route path="/login" element={<Login />} /> 
    </Routes>
  );
}

export default App;
