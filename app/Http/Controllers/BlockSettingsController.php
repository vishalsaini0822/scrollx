<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserBlockSettings;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlockSettingsController extends Controller
{
    /**
     * Save user's block settings to database
     */
    public function saveBlockSettings(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $validated = $request->validate([
                'perBlockSettings' => 'required|array',
                'projectId' => 'required|integer',
                'projectName' => 'string|nullable'
            ]);

            $projectId = $validated['projectId'];
            $projectName = $validated['projectName'] ?? "Project {$projectId}";
            $settingsData = $validated['perBlockSettings'];

            // Use updateOrCreate to handle existing records
            $blockSettings = UserBlockSettings::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'project_name' => $projectId // Store project ID as project_name for now
                ],
                [
                    'settings_data' => $settingsData
                ]
            );

            Log::info('Block settings saved successfully', [
                'user_id' => $user->id,
                'project_id' => $projectId,
                'project_name' => $projectName,
                'settings_count' => count($settingsData)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Block settings saved successfully',
                'data' => [
                    'id' => $blockSettings->id,
                    'project_id' => $projectId,
                    'project_name' => $projectName,
                    'last_modified' => $blockSettings->last_modified
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving block settings', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to save block settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Load user's block settings from database
     */
    public function loadBlockSettings(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $projectId = $request->get('projectId');
            $projectName = $request->get('projectName', 'default');

            if (!$projectId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project ID is required'
                ], 400);
            }

            $blockSettings = UserBlockSettings::where('user_id', $user->id)
                ->where('project_name', $projectId) // Using project_name field to store project ID
                ->first();

            if (!$blockSettings) {
                return response()->json([
                    'success' => true,
                    'message' => 'No saved settings found',
                    'data' => [
                        'perBlockSettings' => [],
                        'hasSettings' => false
                    ]
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Block settings loaded successfully',
                'data' => [
                    'perBlockSettings' => $blockSettings->settings_data,
                    'hasSettings' => true,
                    'project_id' => $projectId,
                    'project_name' => $projectName,
                    'last_modified' => $blockSettings->last_modified
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading block settings', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load block settings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all user's projects with their last modified dates
     */
    public function getUserProjects(): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $projects = UserBlockSettings::where('user_id', $user->id)
                ->select('project_name', 'last_modified')
                ->orderBy('last_modified', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $projects
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching user projects', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch projects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a user's project settings
     */
    public function deleteProject(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated'
                ], 401);
            }

            $validated = $request->validate([
                'projectName' => 'required|string'
            ]);

            $deleted = UserBlockSettings::where('user_id', $user->id)
                ->where('project_name', $validated['projectName'])
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Project deleted successfully'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found'
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error deleting project', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete project',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
