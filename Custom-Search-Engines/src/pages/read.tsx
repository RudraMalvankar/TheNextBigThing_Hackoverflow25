"use client";
import React, { useState } from "react";
import { Send, FileText, Search, Download, X } from "lucide-react";

interface PDFResult {
  title: string;
  link: string;
  snippet: string;
}

const GOOGLE_API_KEY = "AIzaSyCxdgV-myIg_Dn14fluVlReoOHamXhlL0c"; // Replace with your API Key
const GOOGLE_CX_ID = "e5898003666ac4f38"; // Replace with your Custom Search Engine ID

export default function PDFSearch() {
  const [query, setQuery] = useState("");
  const [results, setResults] = useState<PDFResult[]>([]);
  const [isLoading, setIsLoading] = useState(false);
  const [selectedPDF, setSelectedPDF] = useState<string | null>(null);

  const handleSearch = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!query) return;

    setIsLoading(true);
    try {
      const response = await fetch(
        `https://www.googleapis.com/customsearch/v1?q=${query}+education+filetype:pdf&key=${GOOGLE_API_KEY}&cx=${GOOGLE_CX_ID}`
      );
      const data = await response.json();

      const pdfResults = data.items?.map((item: any) => ({
        title: item.title,
        link: item.link,
        snippet: item.snippet,
      })) || [];

      setResults(pdfResults);
    } catch (error) {
      console.error("Error fetching data:", error);
    }
    setIsLoading(false);
  };

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="max-w-4xl mx-auto">
        {/* Header */}
        <div className="flex items-center justify-center mb-8">
          <FileText className="w-8 h-8 text-purple-300 mr-2" />
          <h1 className="text-3xl font-bold text-white">
            PDF <span className="text-purple-300">Search</span>
          </h1>
        </div>

        {/* Search Form */}
        <form onSubmit={handleSearch} className="mb-8">
          <div className="relative flex items-center">
            <input
              type="text"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Search PDFs..."
              className="w-full px-6 py-4 rounded-full bg-white/10 border border-purple-300/20 text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent backdrop-blur-sm"
            />
            <button
              type="submit"
              className="absolute right-2 p-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 transition-all duration-200"
            >
              {isLoading ? (
                <div className="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
              ) : (
                <Send className="w-6 h-6 text-white" />
              )}
            </button>
          </div>
        </form>

        {/* Results */}
        <div className="space-y-6">
          {results.map((result, index) => (
            <div
              key={index}
              className="bg-white/10 rounded-lg overflow-hidden backdrop-blur-sm border border-purple-300/20 hover:bg-white/20 transition-all duration-200 p-6"
            >
              <h3 className="text-xl font-semibold text-white mb-2">
                {result.title}
              </h3>
              <p className="text-purple-200 text-sm mb-4">{result.snippet}</p>
              <button
                onClick={() => setSelectedPDF(result.link)}
                className="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
              >
                <Download className="w-4 h-4 mr-2" />
                <span>View PDF</span>
              </button>
            </div>
          ))}
        </div>

        {/* Empty State */}
        {query && !isLoading && results.length === 0 && (
          <div className="text-center py-12">
            <Search className="w-16 h-16 text-purple-300 mx-auto mb-4" />
            <p className="text-purple-200">
              No PDFs found for "{query}". Try a different search term.
            </p>
          </div>
        )}
      </div>

      {/* PDF Viewer Popup */}
      {selectedPDF && (
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-80 backdrop-blur-lg p-4">
          <div className="relative w-full max-w-4xl h-[80vh] bg-white rounded-lg overflow-hidden">
            <button
              className="absolute top-3 right-3 bg-red-500 text-white p-2 rounded-full hover:bg-red-600"
              onClick={() => setSelectedPDF(null)}
            >
              <X className="w-5 h-5" />
            </button>
            <iframe
              src={selectedPDF}
              className="w-full h-full"
              title="PDF Viewer"
            ></iframe>
          </div>
        </div>
      )}
    </div>
  );
}
