const mongoose = require('mongoose');

const siteSettingsSchema = new mongoose.Schema({
  _id: { type: String, default: 'global' },

  colors: {
    primary:    { type: String, default: '#dfc378' },
    accent:     { type: String, default: '#1a3a2e' },
    background: { type: String, default: '#ffffff' },
    text:       { type: String, default: '#1a2e25' },
    heroBg:     { type: String, default: '#0c3935' },
  },

  fonts: {
    headingFont: { type: String, default: 'Playfair Display' },
    bodyFont:    { type: String, default: 'Inter' },
    baseSize:    { type: String, default: '16px' },
    headingSize: { type: String, default: '2.5rem' },
  },

  hero: {
    badge:    { type: String, default: 'Independent DXN Distributor' },
    title:    { type: String, default: 'Grow Your Health & Wealth with DXN' },
    subtitle: { type: String, default: 'Discover premium Ganoderma products that transform your health, and a business opportunity that can transform your life.' },
    btn1Text: { type: String, default: 'Shop Products' },
    btn1Link: { type: String, default: '/products' },
    btn2Text: { type: String, default: 'Join as a Distributor' },
    btn2Link: { type: String, default: '/join' },
  },

  contact: {
    phone:    { type: String, default: '+971 50 666 2875' },
    email:    { type: String, default: 'info@freedomwithdxn.com' },
    whatsapp: { type: String, default: 'https://wa.me/message/EFSQ2IDNVG3YB1' },
    location: { type: String, default: 'United Arab Emirates' },
  },

  social: {
    facebook:  { type: String, default: '' },
    instagram: { type: String, default: '' },
    youtube:   { type: String, default: '' },
  },

  seo: {
    pageTitle:   { type: String, default: 'Freedom with DXN - Health & Business Opportunity' },
    description: { type: String, default: 'Your trusted DXN distributor. Premium Ganoderma products and business opportunity.' },
    keywords:    { type: String, default: 'DXN, Ganoderma, health products, distributor, coffee, supplements' },
  },

  footer: {
    description: { type: String, default: 'Your trusted DXN distributor. We help you achieve health and financial freedom through DXN\'s world-class products.' },
    copyright:   { type: String, default: 'Freedom with DXN. All rights reserved.' },
  },

  navbar: {
    showHome:     { type: Boolean, default: true },
    showAbout:    { type: Boolean, default: true },
    showProducts: { type: Boolean, default: true },
    showJoin:     { type: Boolean, default: true },
    showZoom:     { type: Boolean, default: true },
    showBlog:     { type: Boolean, default: true },
    showContact:  { type: Boolean, default: true },
  },

  charts: {
    salesChartType:    { type: String, enum: ['line', 'bar'], default: 'line' },
    categoryChartType: { type: String, enum: ['pie', 'bar'],  default: 'pie' },
    revenueChartType:  { type: String, enum: ['bar', 'line'], default: 'bar' },
  },
}, { _id: false, timestamps: true });

module.exports = mongoose.model('SiteSettings', siteSettingsSchema);
