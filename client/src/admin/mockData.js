export const salesData = [
  { date: 'Feb 10', sales: 1200, orders: 8 },
  { date: 'Feb 12', sales: 1800, orders: 12 },
  { date: 'Feb 14', sales: 1400, orders: 9 },
  { date: 'Feb 16', sales: 2200, orders: 15 },
  { date: 'Feb 18', sales: 1900, orders: 13 },
  { date: 'Feb 20', sales: 2800, orders: 19 },
  { date: 'Feb 22', sales: 2400, orders: 16 },
  { date: 'Feb 24', sales: 3100, orders: 22 },
  { date: 'Feb 26', sales: 2700, orders: 18 },
  { date: 'Feb 28', sales: 3400, orders: 24 },
  { date: 'Mar 02', sales: 2900, orders: 20 },
  { date: 'Mar 04', sales: 3800, orders: 27 },
  { date: 'Mar 06', sales: 3200, orders: 23 },
  { date: 'Mar 08', sales: 4100, orders: 29 },
  { date: 'Mar 10', sales: 3700, orders: 26 },
];

export const categoryData = [
  { name: 'Coffee', value: 38, color: '#8B4513' },
  { name: 'Supplements', value: 24, color: '#2d7a4f' },
  { name: 'Beverages', value: 18, color: '#c9a84c' },
  { name: 'Personal Care', value: 12, color: '#6b7280' },
  { name: 'Skin Care', value: 8, color: '#ec4899' },
];

export const orders = [
  { id: 'ORD-001', customer: 'Ahmad Hassan', email: 'ahmad@email.com', product: 'Lingzhi Coffee 3 in 1', amount: 74.97, status: 'Delivered', date: '2026-03-10', items: 3 },
  { id: 'ORD-002', customer: 'Fatima Al-Zahra', email: 'fatima@email.com', product: 'DXN Spirulina 120', amount: 29.99, status: 'Shipped', date: '2026-03-09', items: 1 },
  { id: 'ORD-003', customer: 'Mohammed Yusuf', email: 'myusuf@email.com', product: 'Reishi Mushroom Powder', amount: 128.97, status: 'Pending', date: '2026-03-09', items: 3 },
  { id: 'ORD-004', customer: 'Aisha Binti Malik', email: 'aisha@email.com', product: 'Ganozhi Shampoo + Body Foam', amount: 63.96, status: 'Delivered', date: '2026-03-08', items: 4 },
  { id: 'ORD-005', customer: 'Ibrahim Al-Rashid', email: 'ibrahim@email.com', product: 'DXN Cordyceps Tablet', amount: 39.99, status: 'Cancelled', date: '2026-03-08', items: 1 },
  { id: 'ORD-006', customer: 'Khadijah Nur', email: 'khadijah@email.com', product: 'Ootea Coffee Mix 3in1', amount: 49.98, status: 'Shipped', date: '2026-03-07', items: 2 },
  { id: 'ORD-007', customer: 'Omar Abdullah', email: 'omar@email.com', product: 'DXN MycoVeggie', amount: 34.99, status: 'Delivered', date: '2026-03-07', items: 1 },
  { id: 'ORD-008', customer: 'Zainab Hassan', email: 'zainab@email.com', product: 'Ganozhi Toothpaste x3', amount: 44.97, status: 'Pending', date: '2026-03-06', items: 3 },
  { id: 'ORD-009', customer: 'Yusuf Al-Amin', email: 'yusuf@email.com', product: 'DXN Bee Pollen + Spirulina', amount: 57.98, status: 'Delivered', date: '2026-03-05', items: 2 },
  { id: 'ORD-010', customer: 'Maryam Idris', email: 'maryam@email.com', product: 'Aloe.V Skincare Set', amount: 82.96, status: 'Shipped', date: '2026-03-05', items: 4 },
  { id: 'ORD-011', customer: 'Hassan Salim', email: 'hassan@email.com', product: 'DXN Potenzhi 90', amount: 45.99, status: 'Delivered', date: '2026-03-04', items: 1 },
  { id: 'ORD-012', customer: 'Nur Hafiza', email: 'nurhafiza@email.com', product: 'Lion Mane + Cordyceps Bundle', amount: 75.98, status: 'Pending', date: '2026-03-03', items: 2 },
];

export const members = [
  { id: 'M001', name: 'Ahmad Hassan', email: 'ahmad@email.com', phone: '+60-12-345-6789', joinDate: '2025-06-15', rank: 'Silver', totalSales: 4820, downlines: 12, status: 'Active', country: 'Malaysia' },
  { id: 'M002', name: 'Fatima Al-Zahra', email: 'fatima@email.com', phone: '+60-11-234-5678', joinDate: '2025-07-22', rank: 'Bronze', totalSales: 2140, downlines: 5, status: 'Active', country: 'Malaysia' },
  { id: 'M003', name: 'Mohammed Yusuf', email: 'myusuf@email.com', phone: '+60-13-456-7890', joinDate: '2025-08-10', rank: 'Bronze', totalSales: 1890, downlines: 3, status: 'Active', country: 'Malaysia' },
  { id: 'M004', name: 'Aisha Binti Malik', email: 'aisha@email.com', phone: '+60-14-567-8901', joinDate: '2025-09-05', rank: 'Gold', totalSales: 8340, downlines: 28, status: 'Active', country: 'Malaysia' },
  { id: 'M005', name: 'Ibrahim Al-Rashid', email: 'ibrahim@email.com', phone: '+971-50-123-4567', joinDate: '2025-10-18', rank: 'Bronze', totalSales: 980, downlines: 2, status: 'Inactive', country: 'UAE' },
  { id: 'M006', name: 'Khadijah Nur', email: 'khadijah@email.com', phone: '+60-16-789-0123', joinDate: '2025-11-02', rank: 'Silver', totalSales: 3560, downlines: 9, status: 'Active', country: 'Malaysia' },
  { id: 'M007', name: 'Omar Abdullah', email: 'omar@email.com', phone: '+60-17-890-1234', joinDate: '2025-11-30', rank: 'Bronze', totalSales: 1240, downlines: 4, status: 'Active', country: 'Malaysia' },
  { id: 'M008', name: 'Zainab Hassan', email: 'zainab@email.com', phone: '+60-18-901-2345', joinDate: '2026-01-08', rank: 'Bronze', totalSales: 760, downlines: 1, status: 'Active', country: 'Malaysia' },
  { id: 'M009', name: 'Yusuf Al-Amin', email: 'yusuf@email.com', phone: '+966-50-234-5678', joinDate: '2026-01-20', rank: 'Silver', totalSales: 5120, downlines: 15, status: 'Active', country: 'Saudi Arabia' },
  { id: 'M010', name: 'Maryam Idris', email: 'maryam@email.com', phone: '+60-19-012-3456', joinDate: '2026-02-14', rank: 'Bronze', totalSales: 420, downlines: 0, status: 'Active', country: 'Malaysia' },
];

export const commissions = [
  { id: 'COM-001', period: 'Mar 2026', type: 'Group Bonus', amount: 384.50, status: 'Pending', payDate: '2026-03-31', members: 8 },
  { id: 'COM-002', period: 'Feb 2026', type: 'Retail Profit', amount: 218.75, status: 'Paid', payDate: '2026-02-28', members: 0 },
  { id: 'COM-003', period: 'Feb 2026', type: 'Group Bonus', amount: 312.00, status: 'Paid', payDate: '2026-02-28', members: 7 },
  { id: 'COM-004', period: 'Feb 2026', type: 'Leadership Bonus', amount: 150.00, status: 'Paid', payDate: '2026-02-28', members: 0 },
  { id: 'COM-005', period: 'Jan 2026', type: 'Retail Profit', amount: 195.50, status: 'Paid', payDate: '2026-01-31', members: 0 },
  { id: 'COM-006', period: 'Jan 2026', type: 'Group Bonus', amount: 278.25, status: 'Paid', payDate: '2026-01-31', members: 6 },
  { id: 'COM-007', period: 'Mar 2026', type: 'Retail Profit', amount: 156.80, status: 'Pending', payDate: '2026-03-31', members: 0 },
  { id: 'COM-008', period: 'Dec 2025', type: 'Group Bonus', amount: 425.00, status: 'Paid', payDate: '2025-12-31', members: 9 },
];

export const topProducts = [
  { name: 'Lingzhi Coffee 3 in 1', sold: 248, revenue: 6195.52, image: '/images/products/LC20_LingzhiCoffee3in1.jpg' },
  { name: 'DXN Spirulina 120', sold: 186, revenue: 5573.14, image: '/images/products/SPI120_Spirulina120.jpg' },
  { name: 'DXN MycoVeggie', sold: 142, revenue: 4968.58, image: '/images/products/MYCO_Mycoveggie.jpg' },
  { name: 'Reishi Mushroom Powder', sold: 128, revenue: 5503.72, image: '/images/products/RGLP70_ReishiMushroomPowder70g.jpg' },
  { name: 'Ganozhi Toothpaste', sold: 215, revenue: 2793.35, image: '/images/products/GTP_ToothPaste150g.jpg' },
];
