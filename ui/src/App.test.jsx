import { render, screen, fireEvent } from "@testing-library/react";
import App from "./App";
import { describe, it, expect, vi } from "vitest";
import axios from "axios";

vi.mock("axios");

describe("WaterJugSolver", () => {
  it("renders the form and inputs correctly", () => {
    render(<App />);

    expect(
      screen.getByPlaceholderText(/Enter Jug X Capacity/i)
    ).toBeInTheDocument();
    expect(
      screen.getByPlaceholderText(/Enter Jug Y Capacity/i)
    ).toBeInTheDocument();
    expect(
      screen.getByPlaceholderText(/Enter Target Amount/i)
    ).toBeInTheDocument();
  });

  it("displays an error message when inputs are empty and the button is clicked", async () => {
    render(<App />);

    fireEvent.click(screen.getByTestId(/Solve/i));

    expect(await screen.findByText(/Error/i)).toBeInTheDocument();
  });

  it("makes an API call and displays the solution", async () => {
    axios.post.mockResolvedValueOnce({
      data: {
        solution: [
          { bucketX: 3, bucketY: 0, action: "Fill bucket X" },
          { bucketX: 0, bucketY: 3, action: "Transfer from X to Y" },
          { bucketX: 3, bucketY: 3, action: "Fill bucket X" },
          { bucketX: 1, bucketY: 5, action: "Transfer from X to Y" },
        ],
      },
    });

    render(<App />);

    fireEvent.change(screen.getByTestId("jug-x-capacity"), {
      target: { value: "3" },
    });
    fireEvent.change(screen.getByTestId("jug-y-capacity"), {
      target: { value: "5" },
    });
    fireEvent.change(screen.getByTestId("target"), {
      target: { value: "4" },
    });

    fireEvent.click(screen.getByTestId("solve"));

    expect(await screen.findByTestId("step-1")).toHaveTextContent(
      "Step 1: Fill bucket X (X: 3, Y: 0)"
    );
    expect(await screen.findByTestId("step-2")).toHaveTextContent(
      "Step 2: Transfer from X to Y (X: 0, Y: 3)"
    );
    expect(await screen.findByTestId("step-3")).toHaveTextContent(
      "Step 3: Fill bucket X (X: 3, Y: 3)"
    );
    expect(await screen.findByTestId("step-4")).toHaveTextContent(
      "Step 4: Transfer from X to Y (X: 1, Y: 5)"
    );
  });
});
