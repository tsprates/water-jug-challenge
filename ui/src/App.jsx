import { useState } from "react";
import axios from "axios";

const WaterJugSolver = () => {
  const [xCapacity, setXCapacity] = useState("");
  const [yCapacity, setYCapacity] = useState("");
  const [target, setTarget] = useState("");
  const [solution, setSolution] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  const handleSubmit = async () => {
    setLoading(true);
    setError(null);
    setSolution(null);

    try {
      const response = await axios.post(
        "http://localhost:8000/api/water-jug-solution",
        {
          x_capacity: parseInt(xCapacity),
          y_capacity: parseInt(yCapacity),
          z_amount_wanted: parseInt(target),
        }
      );

      setSolution(response.data.solution);
      setError(response.data.error || null);
    } catch (err) {
      setError("Error", err);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100 p-6">
      <div className="w-full max-w-md">
        <div className="bg-white shadow-md rounded-lg p-6">
          <h1 className="text-3xl font-bold mb-6 text-center">
            Water Jug Solver
          </h1>

          <div className="mb-4">
            <label className="block text-gray-700">X Capacity:</label>
            <input
              type="number"
              value={xCapacity}
              onChange={(e) => setXCapacity(e.target.value)}
              className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter Jug X Capacity"
              data-testid="jug-x-capacity"
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700">Y Capacity:</label>
            <input
              type="number"
              value={yCapacity}
              onChange={(e) => setYCapacity(e.target.value)}
              className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter Jug Y Capacity"
              data-testid="jug-y-capacity"
            />
          </div>
          <div className="mb-4">
            <label className="block text-gray-700">Target:</label>
            <input
              type="number"
              value={target}
              onChange={(e) => setTarget(e.target.value)}
              className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Enter Target Amount"
              data-testid="target"
            />
          </div>
          {error && <p className="text-red-500 text-center mb-4">{error}</p>}
          <button
            onClick={handleSubmit}
            className={`w-full bg-blue-500 text-white py-2 px-4 rounded-lg transition-all duration-200 hover:bg-blue-600 ${
              loading ? "opacity-50 cursor-not-allowed" : ""
            }`}
            disabled={loading}
            data-testid="solve"
          >
            {loading ? "Loading..." : "Solve"}
          </button>
        </div>

        {solution && (
          <div className="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 className="text-xl font-semibold mb-4 text-center">Solution</h2>
            <ul className="list-disc list-inside space-y-2">
              {solution.map((step, index) => (
                <li key={index} className="text-gray-700" data-testid={`step-${index+1}`}>
                  <strong>Step {index + 1}</strong>:{` ${step.action} (X: ${step.bucketX}, Y: ${step.bucketY})`}
                </li>
              ))}
            </ul>
          </div>
        )}
      </div>
    </div>
  );
};

export default WaterJugSolver;
