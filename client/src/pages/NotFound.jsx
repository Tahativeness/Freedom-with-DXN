import { Link } from 'react-router-dom';

export default function NotFound() {
  return (
    <div className="min-h-screen bg-gray-50 flex flex-col items-center justify-center px-4 text-center">
      <div className="text-8xl font-bold text-dxn-green/20 mb-4">404</div>
      <h1 className="text-2xl font-bold text-dxn-darkgreen mb-2">Page Not Found</h1>
      <p className="text-gray-500 mb-8">The page you're looking for doesn't exist or has been moved.</p>
      <Link to="/" className="btn-primary">Go Back Home</Link>
    </div>
  );
}
