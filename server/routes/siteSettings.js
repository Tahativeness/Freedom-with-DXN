const express = require('express');
const router = express.Router();
const SiteSettings = require('../models/SiteSettings');
const { authMiddleware, adminMiddleware } = require('../middleware/auth');

// GET — public
router.get('/', async (req, res) => {
  try {
    let settings = await SiteSettings.findById('global');
    if (!settings) settings = await SiteSettings.create({ _id: 'global' });
    res.json(settings);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// PUT — admin only
router.put('/', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    const settings = await SiteSettings.findByIdAndUpdate(
      'global',
      { $set: req.body },
      { new: true, upsert: true, runValidators: false }
    );
    res.json(settings);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

module.exports = router;
