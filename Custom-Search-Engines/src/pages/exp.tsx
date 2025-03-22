"use client";
import React, { useState } from "react";
import { Send, Search, Loader } from "lucide-react";


const API_KEY = "AIzaSyCxdgV-myIg_Dn14fluVlReoOHamXhlL0c"; // 🔥 Replace with your Google API key
const CX = "b30f9129e78aa400a"; // 🔥 Replace with your CSE ID

export default function ScienceExperiments() {
  const [query, setQuery] = useState("");
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);

  const searchExperiments = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    try {
      const res = await fetch(
        `https://www.googleapis.com/customsearch/v1?q=${query}&key=${API_KEY}&cx=${CX}`
      );
      const data = await res.json();
      setResults(data.items || []);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
    setLoading(false);
  };

  return (
    
      <div className="max-w-4xl mx-auto">
        {/* Header */}
        <div className="flex items-center justify-center mb-8">
          <h1 className="text-3xl font-bold text-white">🔬 Science Experiment Finder</h1>
        </div>

        {/* Search Form */}
        <form onSubmit={searchExperiments} className="mb-6 flex items-center">
          <input
            type="text"
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Search for science experiments..."
            className="w-full p-4 rounded-l bg-white/10 border border-purple-300/20 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400"
          />
          <button
            type="submit"
            className="p-4 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 rounded-r"
          >
            {loading ? <Loader className="w-6 h-6 animate-spin text-white" /> : <Send className="w-6 h-6 text-white" />}
          </button>
        </form>

        {/* Results */}
        <div className="space-y-6">
          {results.map((item, index) => (
            <div key={index} className="bg-white/10 p-6 rounded-lg border border-purple-300/20 hover:bg-white/20 transition">
              <h2 className="text-xl font-semibold text-white">{item.title}</h2>
              <p className="text-purple-200">{item.snippet}</p>
              <a href={item.link} target="_blank" rel="noopener noreferrer" className="text-blue-300 underline">
                View Experiment
              </a>
            </div>
          ))}
        </div>

        {/* Empty State */}
        {query && !loading && results.length === 0 && (
          <div className="text-center py-12">
            <Search className="w-16 h-16 text-purple-300 mx-auto mb-4" />
            <p className="text-purple-200">No experiments found for "{query}". Try a different search term.</p>
          </div>
        )}
      </div>
    
  );
}
