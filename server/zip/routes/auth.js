const express = require('express');
const router = express.Router();
const { register, login, getMe, updateProfile } = require('../controllers/authController');
const { authMiddleware } = require('../middleware/auth');
const ContactMessage = require('../models/ContactMessage');

router.post('/register', register);
router.post('/login', login);
router.get('/me', authMiddleware, getMe);
router.put('/profile', authMiddleware, updateProfile);

// Contact form
router.post('/contact', async (req, res) => {
  try {
    const msg = await ContactMessage.create(req.body);
    res.status(201).json({ message: 'Message sent successfully', id: msg._id });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

module.exports = router;
